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
$pageTitle = 'Migrations';
$pageSubtitle = 'Versionamento de esquema, compatível com todos os SGBD suportados';
$activeSlug = 'migrations';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-plus"></i>Criar uma migration</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver make:migration create_articles_table</code></pre>
        <pre><code class="language-php">use Beaver\Database\Migration;
use Beaver\Database\Schema;
use Beaver\Database\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->boolean('published')->default(false);
            $table->foreignId('author_id')->references('users');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('articles');
    }
};</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-pen-to-square"></i>Alterar tabelas existentes</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver make:migration add_views_to_articles_table --table=articles</code></pre>
        <pre><code class="language-php">Schema::table('articles', function (Blueprint $table) {
    $table->integer('views')->default(0)->after('body');
    $table->index('views');
});</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i>Comandos</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver migrate              # aplica migrations pendentes
php beaver migrate:rollback     # reverte o último batch
php beaver migrate:reset        # reverte tudo
php beaver migrate:fresh        # dropa tudo e recria do zero
php beaver migrate:status       # lista o estado de cada migration</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-database"></i>Compatibilidade multi-SGBD</h2>
    <div class="beaver-card">
        <p class="mb-0">
            O <code class="inline-code">Blueprint</code> traduz automaticamente os tipos de coluna para a sintaxe nativa
            de cada motor — a mesma migration corre sem alterações em MySQL, PostgreSQL, SQLite ou LocalDB.
        </p>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
