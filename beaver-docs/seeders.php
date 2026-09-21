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
$pageTitle = 'Seeders';
$pageSubtitle = 'Popular a base de dados com dados de teste ou iniciais';
$activeSlug = 'seeders';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-seedling"></i>Criar um Seeder</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver make:seeder ArticleSeeder</code></pre>
        <pre><code class="language-php">namespace Database\Seeders;

use Beaver\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('email', 'admin@exemplo.com')->firstOrFail();

        Article::create([
            'title'     => 'Bem-vindo ao Beaver Framework',
            'body'      => 'Este é o primeiro artigo gerado pelo seeder.',
            'published' => true,
            'author_id' => $author->id,
        ]);
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-industry"></i>Factories — dados em massa</h2>
    <div class="beaver-card">
        <pre><code class="language-php">namespace Database\Factories;

use Beaver\Database\Factory;
use App\Models\Article;

class ArticleFactory extends Factory
{
    protected string $model = Article::class;

    public function definition(): array
    {
        return [
            'title'     => $this->faker->sentence(6),
            'body'      => $this->faker->paragraphs(3, true),
            'published' => $this->faker->boolean(80),
            'author_id' => User::factory(),
        ];
    }
}</code></pre>
        <pre><code class="language-php">// Dentro do seeder, ou em testes
Article::factory()->count(50)->create();

// Com estado customizado
Article::factory()
    ->count(5)
    ->state(['published' => false])
    ->create();</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-list-check"></i>Registar e executar</h2>
    <div class="beaver-card">
        <p><code class="inline-code">database/seeders/DatabaseSeeder.php</code>:</p>
        <pre><code class="language-php">class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ArticleSeeder::class,
            TagSeeder::class,
        ]);
    }
}</code></pre>
        <pre><code class="language-bash">php beaver db:seed                       # corre DatabaseSeeder
php beaver db:seed --class=ArticleSeeder  # corre um seeder específico
php beaver migrate:fresh --seed           # recria as tabelas e semeia de seguida</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
