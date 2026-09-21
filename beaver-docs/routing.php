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
$pageTitle = 'Routing';
$pageSubtitle = 'Definição de rotas, grupos, middleware e parâmetros';
$activeSlug = 'routing';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-route"></i>Rotas básicas</h2>
    <div class="beaver-card">
        <p><code class="inline-code">routes/web.php</code>:</p>
        <pre><code class="language-php">use Beaver\Routing\Route;
use App\Controllers\ArticleController;

Route::get('/', fn() => view('home'));

Route::get('/artigos', [ArticleController::class, 'index']);
Route::get('/artigos/{id}', [ArticleController::class, 'show']);
Route::post('/artigos', [ArticleController::class, 'store'])
    ->middleware('auth');
Route::put('/artigos/{id}', [ArticleController::class, 'update']);
Route::delete('/artigos/{id}', [ArticleController::class, 'destroy']);</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-layer-group"></i>Grupos de rotas</h2>
    <div class="beaver-card">
        <pre><code class="language-php">Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::resource('users', AdminUserController::class);
    });</code></pre>
        <p class="mt-2 mb-0 text-muted small">
            <code class="inline-code">Route::resource()</code> gera automaticamente as 7 rotas RESTful padrão
            (index, create, store, show, edit, update, destroy).
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-shield"></i>Middleware</h2>
    <div class="beaver-card">
        <pre><code class="language-php">namespace App\Middleware;

use Beaver\Http\Request;
use Closure;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()?->isAdmin()) {
            abort(403, 'Acesso negado');
        }

        return $next($request);
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-link"></i>Parâmetros e restrições</h2>
    <div class="beaver-card">
        <pre><code class="language-php">Route::get('/artigos/{id}', [ArticleController::class, 'show'])
    ->where('id', '[0-9]+');

Route::get('/utilizadores/{username}', [UserController::class, 'show'])
    ->where('username', '[a-z0-9_-]+');</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
