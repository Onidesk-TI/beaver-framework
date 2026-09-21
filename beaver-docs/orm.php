<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */
$pageTitle = 'ORM & Models';
$pageSubtitle = 'Mapeamento objeto-relacional, relações e query builder';
$activeSlug = 'orm';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-cube"></i>Definir um Model</h2>
    <div class="beaver-card">
        <pre><code class="language-php">namespace App\Models;

use Beaver\ORM\Model;

class Article extends Model
{
    protected string $table = 'articles';
    protected array $fillable = ['title', 'body', 'published', 'author_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-magnifying-glass"></i>Query builder</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// Buscar com relações (eager loading)
$article = Article::query()->with('author', 'comments')->find(1);

// Filtros encadeados
$published = Article::query()
    ->where('published', true)
    ->whereNotNull('author_id')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

// Agregações
$total = Article::query()->where('published', true)->count();
$media = Comment::query()->avg('rating');

// Criar / atualizar / apagar
$article = Article::create(['title' => 'Novo artigo', 'body' => '...']);
$article->update(['published' => true]);
$article->delete();</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-shield-halved"></i>Proteção contra SQL Injection</h2>
    <div class="beaver-card">
        <p class="mb-2">Todas as queries do ORM usam <em>prepared statements</em> automaticamente — os valores nunca são concatenados na string SQL:</p>
        <pre><code class="language-php">// Seguro — o valor é passado como parâmetro vinculado, não concatenado
Article::query()->where('title', $request->input('busca'))->get();

// Query "raw" também suporta bindings — nunca interpoles diretamente
Article::rawQuery('SELECT * FROM articles WHERE title LIKE ?', ["%{$termo}%"]);</code></pre>
        <p class="mt-2 mb-0 text-muted small">
            O scanner de segurança do FrankenPHP (ver secção dedicada) deteta automaticamente pontos onde SQL é
            construído por concatenação direta de variáveis do pedido.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-pen"></i>Mutators &amp; Casts</h2>
    <div class="beaver-card">
        <pre><code class="language-php">class Article extends Model
{
    protected array $casts = [
        'published'  => 'boolean',
        'metadata'   => 'array',   // JSON ↔ array PHP automático
        'created_at' => 'datetime',
    ];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucfirst($value),
        );
    }
}</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
