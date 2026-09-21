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
$pageTitle = 'Unity Test';
$pageSubtitle = 'Ferramenta nativa de testes unitários do Beaver Framework';
$activeSlug = 'testing';
require __DIR__ . '/partials/head.php';
?>

<!-- ============================================================ -->
<!-- CSS ESPECÍFICO DA PÁGINA TESTING                              -->
<!-- ============================================================ -->
<style>
    /* ============================================================ */
    /* PALETA BEAVER                                                */
    /* ============================================================ */
    :root {
        --beaver-walnut: #4A2C1D;
        --beaver-walnut-dark: #2E1A10;
        --beaver-oak: #A0693D;
        --beaver-oak-light: #C98A4F;
        --beaver-cream: #F5EBD8;
    }

    /* ============================================================ */
    /* TABS                                                         */
    /* ============================================================ */
    .testing-tabs {
        border-bottom: 2px solid rgba(160, 105, 61, 0.25);
        gap: 4px;
        flex-wrap: wrap;
    }
    .testing-tabs .nav-link {
        color: var(--beaver-walnut);
        opacity: 0.65;
        border: none;
        border-bottom: 2px solid transparent;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.6rem 1rem;
        border-radius: 0;
        transition: all 0.2s ease;
        background: transparent;
    }
    .testing-tabs .nav-link i {
        margin-right: 6px;
        font-size: 0.85rem;
    }
    .testing-tabs .nav-link:hover {
        color: var(--beaver-oak);
        opacity: 1;
        border-bottom-color: var(--beaver-oak-light);
        background: rgba(201, 138, 79, 0.08);
    }
    .testing-tabs .nav-link.active {
        color: var(--beaver-oak);
        background: transparent;
        border-bottom-color: var(--beaver-oak);
        font-weight: 600;
        opacity: 1;
    }
    .tab-content {
        padding-top: 1.25rem;
    }

    /* ============================================================ */
    /* SECÇÕES E CARDS                                              */
    /* ============================================================ */
    .beaver-section {
        margin-bottom: 2rem;
    }
    .beaver-section h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--beaver-walnut);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .beaver-section h2 i {
        color: var(--beaver-oak);
    }
    .beaver-card {
        background: #fff;
        border: 1px solid rgba(74, 44, 29, 0.12);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(74, 44, 29, 0.06);
    }

    /* ============================================================ */
    /* CODE BLOCKS                                                  */
    /* ============================================================ */
    .beaver-card pre {
        background: var(--beaver-walnut-dark);
        color: var(--beaver-cream);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-size: 0.85rem;
        line-height: 1.6;
        overflow-x: auto;
        margin: 0.5rem 0;
        border-left: 3px solid var(--beaver-oak);
    }
    .beaver-card pre code {
        color: inherit;
        background: transparent;
        padding: 0;
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    }

    /* ============================================================ */
    /* INLINE CODE                                                  */
    /* ============================================================ */
    .inline-code {
        background: rgba(160, 105, 61, 0.15);
        color: var(--beaver-oak);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.85em;
        font-family: 'Consolas', 'Monaco', monospace;
    }

    /* ============================================================ */
    /* SYNTAX HIGHLIGHT (básico)                                    */
    /* ============================================================ */
    .language-php .token-keyword,
    .language-php .token-function { color: var(--beaver-oak-light); }
    .language-bash { color: #b8e0a8; }
    .language-bash .token-comment { color: #8a7a6a; }
    .language-text { color: var(--beaver-cream); }

    /* ============================================================ */
    /* OUTPUT DE TESTES                                             */
    /* ============================================================ */
    .test-output {
        background: var(--beaver-walnut-dark);
        border-left: 3px solid #22c55e;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.85rem;
        line-height: 1.7;
        color: var(--beaver-cream);
        white-space: pre;
        overflow-x: auto;
    }
    .test-output .pass { color: #6ee7a8; }
    .test-output .fail { color: #f87171; }
    .test-output .desc { color: var(--beaver-oak-light); }
    .test-output .gray { color: #a89684; }

    /* ============================================================ */
    /* FOLDER TREE                                                  */
    /* ============================================================ */
    .folder-tree {
        background: var(--beaver-cream);
        border: 1px solid rgba(74, 44, 29, 0.15);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.85rem;
        line-height: 1.7;
        color: var(--beaver-walnut);
        white-space: pre;
        overflow-x: auto;
    }

    /* ============================================================ */
    /* LISTAS                                                       */
    /* ============================================================ */
    .beaver-card ul {
        padding-left: 1.25rem;
        margin: 0;
    }
    .beaver-card ul li {
        margin-bottom: 0.4rem;
        color: var(--beaver-walnut);
        opacity: 0.85;
    }

    /* ============================================================ */
    /* TEXTO AUXILIAR                                               */
    /* ============================================================ */
    .beaver-card p {
        color: var(--beaver-walnut);
        opacity: 0.9;
    }
    .beaver-card .text-muted,
    .beaver-card .small {
        color: var(--beaver-walnut) !important;
        opacity: 0.65;
    }
    .beaver-card .fw-bold {
        color: var(--beaver-walnut);
    }
    .beaver-card strong {
        color: var(--beaver-walnut);
    }

    /* ============================================================ */
    /* RESPONSIVO                                                   */
    /* ============================================================ */
    @media (max-width: 768px) {
        .testing-tabs .nav-link {
            font-size: 0.8rem;
            padding: 0.5rem 0.7rem;
        }
        .testing-tabs .nav-link i {
            margin-right: 4px;
        }
        .beaver-card pre {
            font-size: 0.78rem;
        }
        .folder-tree,
        .test-output {
            font-size: 0.75rem;
        }
    }
</style>

<!-- ============================================================ -->
<!-- CONTEÚDO                                                      -->
<!-- ============================================================ -->

<section class="beaver-section">
    <h2><i class="fas fa-bug"></i> O que é o Unity Test</h2>
    <div class="beaver-card">
        <p class="mb-2">
            O <strong>Unity Test</strong> é a ferramenta nativa de testes do Beaver Framework. Construído
            do zero, sem dependências externas obrigatórias, oferece uma sintaxe simples e expressiva,
            inspirada no <strong>Pest</strong>, mas ainda mais leve e prática.
        </p>
        <p class="mb-0">
            Corre com um único comando: <code class="inline-code">php beaver test</code>.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-layer-group"></i> Exemplos</h2>
    <div class="beaver-card">

        <!-- TABS -->
        <ul class="nav nav-tabs testing-tabs mb-2" id="testingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-basico" data-bs-toggle="tab"
                        data-bs-target="#pane-basico" type="button" role="tab">
                    <i class="fas fa-play"></i> Básico
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-assertions" data-bs-toggle="tab"
                        data-bs-target="#pane-assertions" type="button" role="tab">
                    <i class="fas fa-check-double"></i> Assertions
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-describe" data-bs-toggle="tab"
                        data-bs-target="#pane-describe" type="button" role="tab">
                    <i class="fas fa-sitemap"></i> Describe
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-database" data-bs-toggle="tab"
                        data-bs-target="#pane-database" type="button" role="tab">
                    <i class="fas fa-database"></i> Database
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-http" data-bs-toggle="tab"
                        data-bs-target="#pane-http" type="button" role="tab">
                    <i class="fas fa-globe"></i> HTTP
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-commands" data-bs-toggle="tab"
                        data-bs-target="#pane-commands" type="button" role="tab">
                    <i class="fas fa-terminal"></i> Commands
                </button>
            </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-middleware" data-bs-toggle="tab"
            data-bs-target="#pane-middleware" type="button" role="tab">
            <i class="fas fa-shield-alt"></i> Middleware
            </button>
        </li>
        </ul>

        <div class="tab-content" id="testingTabsContent">

            <!-- ============================================================ -->
            <!-- TAB 1 — BÁSICO                                                -->
            <!-- ============================================================ -->
            <div class="tab-pane fade show active" id="pane-basico" role="tabpanel">

                <p class="mb-2">
                    O teste mais simples possível. Um ficheiro, uma função, uma asserção.
                </p>

                <p class="mb-1 fw-bold">1. Criar o ficheiro</p>
                <pre><code class="language-bash">mkdir -p tests/Unit
touch tests/Unit/ExampleTest.php</code></pre>

                <p class="mt-3 mb-1 fw-bold">2. Escrever o teste</p>
                <pre><code class="language-php">use Beaver\Testing\UnityTest;

UnityTest::test('a matemática funciona', function () {
    UnityTest::assertSame(4, 2 + 2, 'Dois mais dois deve ser quatro');
});</code></pre>

                <p class="mt-3 mb-1 fw-bold">3. Correr</p>
                <pre><code class="language-bash">php beaver test tests/Unit/ExampleTest.php</code></pre>

                <p class="mt-3 mb-1 fw-bold">4. Resultado</p>
                <div class="test-output">🦫 Beaver Unity Test
   A correr testes em tests/Unit

<span class="gray">📄 ExampleTest.php</span>
  <span class="pass">✓</span> a matemática funciona

<span class="gray">──────────────────────────────────────────────────</span>
<span class="pass">✅ PASSOU</span>
   <span class="pass">1 testes, 1 assertions</span>

<span class="gray">⏱  0.002s</span>
<span class="gray">──────────────────────────────────────────────────</span></div>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 2 — ASSERTIONS                                            -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-assertions" role="tabpanel">

                <p class="mb-2">
                    Todas as assertions disponíveis no Unity Test. Sem mágica, apenas PHP.
                </p>

                <p class="mb-1 fw-bold">Igualdade estrita</p>
                <pre><code class="language-php">UnityTest::assertSame(2, 2);                    // ✅
UnityTest::assertSame('2', 2);                  // ❌ tipos diferentes
UnityTest::assertSame([1,2], [1,2]);            // ✅ arrays idênticos</code></pre>

                <p class="mt-3 mb-1 fw-bold">Verdadeiro / Falso</p>
                <pre><code class="language-php">UnityTest::assertTrue(true);
UnityTest::assertFalse(false);
UnityTest::assertTrue(1 === 1, 'Mensagem custom');</code></pre>

                <p class="mt-3 mb-1 fw-bold">Pertence a array</p>
                <pre><code class="language-php">UnityTest::assertContains('admin', ['admin', 'user']);
UnityTest::assertContains(42, [10, 42, 100]);</code></pre>

                <p class="mt-3 mb-1 fw-bold">Custom / geral</p>
                <pre><code class="language-php">UnityTest::assert($user->isActive(), 'User deve estar ativo');
UnityTest::assert(count($items) > 0, 'Lista não pode estar vazia');</code></pre>

                <p class="mt-3 mb-1 fw-bold">Skip</p>
                <pre><code class="language-php">UnityTest::test('integração externa', function () {
    UnityTest::skip('A aguardar API de terceiros');
});</code></pre>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 3 — DESCRIBE                                              -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-describe" role="tabpanel">

                <p class="mb-2">
                    Agrupa testes por contexto para leitura mais clara.
                </p>

                <pre><code class="language-php">use Beaver\Testing\UnityTest;
use App\Models\User;

UnityTest::describe('User', function () {

    UnityTest::test('tem nome completo', function () {
        $user = new User(['first_name' => 'Franco', 'last_name' => 'Jose']);
        UnityTest::assertSame('Franco Jose', $user->fullName());
    });

    UnityTest::test('valida email', function () {
        $user = new User(['email' => 'invalido']);
        UnityTest::assertFalse($user->hasValidEmail());
    });

});

UnityTest::describe('Newsletter', function () {

    UnityTest::test('conta subscritores ativos', function () {
        $subscribers = [
            ['email' => 'a@ex.com', 'active' => true],
            ['email' => 'b@ex.com', 'active' => false],
            ['email' => 'c@ex.com', 'active' => true],
        ];
        $active = array_filter($subscribers, fn($s) => $s['active']);
        UnityTest::assertSame(2, count($active));
    });

});</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="test-output"><span class="desc">📦 User</span>
  <span class="pass">✓</span> tem nome completo
  <span class="pass">✓</span> valida email

<span class="desc">📦 Newsletter</span>
  <span class="pass">✓</span> conta subscritores ativos</div>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 4 — DATABASE                                              -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-database" role="tabpanel">

                <p class="mb-2">
                    Testa models, queries e persistência. Usa uma base de dados em memória
                    (SQLite) por defeito para não sujar a BD real.
                </p>

                <p class="mb-1 fw-bold">Preparar</p>
                <pre><code class="language-php">use Beaver\Testing\UnityTest;
use App\Models\User;

UnityTest::describe('User Model', function () {

    UnityTest::test('cria utilizador na base de dados', function () {
        $user = User::create([
            'name'  => 'Franco',
            'email' => 'franco@example.com',
        ]);

        UnityTest::assertTrue($user->id > 0, 'ID deve ser gerado');
        UnityTest::assertSame('franco@example.com', $user->email);
    });

    UnityTest::test('encontra utilizador por email', function () {
        User::create(['name' => 'Maria', 'email' => 'maria@example.com']);

        $found = User::query()->where('email', 'maria@example.com')->first();

        UnityTest::assertTrue($found !== null, 'Utilizador deve existir');
        UnityTest::assertSame('Maria', $found->name);
    });

});</code></pre>

                <p class="mt-3 mb-1 fw-bold">Helpers de BD (futuro)</p>
                <pre><code class="language-php">UnityTest::assertDatabaseHas('users', ['email' => 'franco@example.com']);
UnityTest::assertDatabaseMissing('users', ['email' => 'fantasma@example.com']);
UnityTest::assertDatabaseCount('users', 3);</code></pre>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 5 — HTTP                                                  -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-http" role="tabpanel">

                <p class="mb-2">
                    Testa rotas, controllers e respostas HTTP sem servidor externo.
                </p>

                <pre><code class="language-php">use Beaver\Testing\UnityTest;
use Beaver\Testing\Http;

UnityTest::describe('Rotas públicas', function () {

    UnityTest::test('GET / devolve 200', function () {
        $response = Http::get('/');

        UnityTest::assertSame(200, $response->status());
    });

    UnityTest::test('GET /nao-existe devolve 404', function () {
        $response = Http::get('/nao-existe');

        UnityTest::assertSame(404, $response->status());
    });

    UnityTest::test('POST /register cria utilizador', function () {
        $response = Http::post('/register', [
            'name'     => 'Franco',
            'email'    => 'franco@example.com',
            'password' => 'secret123',
        ]);

        UnityTest::assertSame(302, $response->status());
        UnityTest::assertDatabaseHas('users', ['email' => 'franco@example.com']);
    });

});</code></pre>

                <p class="mt-3 mb-1 fw-bold">Helpers HTTP (futuro)</p>
                <pre><code class="language-php">$response->assertStatus(200);
$response->assertRedirect('/bem-vindo');
$response->assertSee('Bem-vindo');
$response->assertJson(['status' => 'ok']);</code></pre>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 6 — COMMANDS                                              -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-commands" role="tabpanel">

                <p class="mb-2">
                    Testa os teus próprios comandos CLI do Beaver.
                </p>

                <p class="mb-1 fw-bold">Comando a testar</p>
                <pre><code class="language-php">namespace App\Commands;

use Beaver\Console\Command;

class SendNewsletterCommand extends Command
{
    protected string $signature = 'newsletter:send {--dry-run : Não envia, só simula}';
    protected string $description = 'Envia a newsletter semanal';

    public function handle(): int
    {
        $subscribers = Subscriber::query()->where('active', true)->get();
        $this->info("A enviar para {$subscribers->count()} subscritores...");
        return self::SUCCESS;
    }
}</code></pre>

                <p class="mt-3 mb-1 fw-bold">Teste do comando</p>
                <pre><code class="language-php">use Beaver\Testing\UnityTest;
use Beaver\Testing\Command;

UnityTest::describe('SendNewsletterCommand', function () {

    UnityTest::test('comando existe e é executável', function () {
        $result = Command::run('newsletter:send', ['--dry-run' => true]);

        UnityTest::assertSame(0, $result->exitCode(), 'Comando deve retornar SUCCESS');
    });

    UnityTest::test('dry-run não envia emails', function () {
        $result = Command::run('newsletter:send', ['--dry-run' => true]);

        UnityTest::assertContains(
            'A enviar para 0 subscritores',
            $result->output()
        );
    });

    UnityTest::test('comando falha com argumento inválido', function () {
        $result = Command::run('newsletter:send', ['--invalido' => true]);

        UnityTest::assertTrue($result->exitCode() !== 0);
    });

});</code></pre>
            </div>

            <!-- ============================================================ -->
<!-- TAB 7 — MIDDLEWARE                                            -->
<!-- ============================================================ -->
<div class="tab-pane fade" id="pane-middleware" role="tabpanel">

    <p class="mb-3">
        Um <strong>Middleware</strong> é uma camada que processa o pedido HTTP
        <strong>entre</strong> o momento em que chega ao servidor e o momento em que a resposta é devolvida.
        Serve para autenticar, registar, validar, modificar ou bloquear pedidos — <strong>antes</strong>
        de chegarem ao controller.
    </p>

    <!-- Fluxo visual -->
    <p class="mb-1 fw-bold">Como funciona o fluxo</p>
    <div class="folder-tree">Request → Middleware 1 → Middleware 2 → Middleware 3 → Controller → Response
              │              │              │
           (auth)         (log)         (csrf)
              │              │              │
              └── se falhar ─┴── se falhar ─┴── devolve 401/403 e interrompe</div>

    <!-- 1. Middleware simples -->
    <p class="mt-4 mb-1 fw-bold">1. Middleware simples (closure)</p>
    <p class="mb-2">Para casos rápidos, sem criar ficheiro:</p>
    <pre><code class="language-php">use Beaver\Http\Request;
use Beaver\Http\Response;

Route::get('/admin', function (Request $request) {
    return Response::json(['ok' => true]);
})->middleware(function (Request $request, callable $next) {
    if (! $request->user()?->isAdmin()) {
        return Response::json(['error' => 'Acesso negado'], 403);
    }
    return $next($request);
});</code></pre>

    <!-- 2. Middleware em classe -->
    <p class="mt-4 mb-1 fw-bold">2. Middleware em classe (recomendado)</p>
    <p class="mb-2">Cria com o comando:</p>
    <pre><code class="language-bash">php beaver make:middleware AuthMiddleware</code></pre>
    <p class="mb-2">Resultado em <code class="inline-code">app/Middleware/AuthMiddleware.php</code>:</p>
    <pre><code class="language-php">namespace App\Middleware;

use Beaver\Http\Request;
use Beaver\Http\Response;

class AuthMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        // 1. Antes de chegar ao controller
        if (! $request->user()) {
            return Response::redirect('/login');
        }

        // 2. Passa para o próximo middleware / controller
        $response = $next($request);

        // 3. Depois da resposta (opcional)
        $response->headers()->set('X-Auth', 'verified');

        return $response;
    }
}</code></pre>

    <!-- 3. Registar globalmente -->
    <p class="mt-4 mb-1 fw-bold">3. Registar globalmente</p>
    <p class="mb-2">Aplica a <strong>todos</strong> os pedidos, em <code class="inline-code">app/Providers/HttpServiceProvider.php</code>:</p>
    <pre><code class="language-php">use App\Middleware\AuthMiddleware;
use App\Middleware\LogMiddleware;
use App\Middleware\CsrfMiddleware;

public function middlewares(): array
{
    return [
        LogMiddleware::class,      // 1.º a correr
        CsrfMiddleware::class,     // 2.º
        AuthMiddleware::class,     // 3.º
    ];
}</code></pre>

    <!-- 4. Aplicar a rotas -->
    <p class="mt-4 mb-1 fw-bold">4. Aplicar a rotas específicas</p>
    <pre><code class="language-php">// Numa rota
Route::get('/perfil', [ProfileController::class, 'show'])
    ->middleware('auth');

// Num grupo de rotas
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/users',  [AdminController::class, 'users']);
    Route::get('/admin/stats',  [AdminController::class, 'stats']);
});</code></pre>

    <!-- 5. Exemplos práticos -->
    <p class="mt-4 mb-1 fw-bold">5. Exemplos práticos do dia-a-dia</p>

    <p class="mb-1 mt-2"><strong>LogMiddleware</strong> — registar todos os pedidos</p>
    <pre><code class="language-php">namespace App\Middleware;

use Beaver\Http\Request;
use Beaver\Http\Response;
use Beaver\Support\Log;

class LogMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $ms = round((microtime(true) - $start) * 1000, 2);
        Log::info("{$request->method()} {$request->path()} → {$response->status()} ({$ms}ms)");

        return $response;
    }
}</code></pre>

    <p class="mb-1 mt-3"><strong>CsrfMiddleware</strong> — proteger formulários</p>
    <pre><code class="language-php">namespace App\Middleware;

use Beaver\Http\Request;
use Beaver\Http\Response;

class CsrfMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        // Só valida métodos que alteram estado
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $token = $request->input('_token') ?? $request->header('X-CSRF-Token');

            if (! hash_equals($request->session()->get('csrf_token', ''), $token ?? '')) {
                return Response::json(['error' => 'CSRF token inválido'], 419);
            }
        }

        return $next($request);
    }
}</code></pre>

    <p class="mb-1 mt-3"><strong>RateLimitMiddleware</strong> — limitar pedidos por IP</p>
    <pre><code class="language-php">namespace App\Middleware;

use Beaver\Http\Request;
use Beaver\Http\Response;
use Beaver\Support\Cache;

class RateLimitMiddleware
{
    public int $maxAttempts = 60;
    public int $decaySeconds = 60;

    public function handle(Request $request, callable $next): Response
    {
        $key = 'rate_limit:' . $request->ip();
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            return Response::json([
                'error' => 'Demasiados pedidos. Tenta novamente em breve.'
            ], 429);
        }

        Cache::put($key, $attempts + 1, $this->decaySeconds);

        return $next($request);
    }
}</code></pre>

    <p class="mb-1 mt-3"><strong>AdminMiddleware</strong> — restringir acesso</p>
    <pre><code class="language-php">namespace App\Middleware;

use Beaver\Http\Request;
use Beaver\Http\Response;

class AdminMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        if (! $request->user()?->hasRole('admin')) {
            return Response::json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}</code></pre>

    <!-- 6. Testar middleware -->
    <p class="mt-4 mb-1 fw-bold">6. Testar middlewares com o Unity Test</p>
    <pre><code class="language-php">use Beaver\Testing\UnityTest;
use Beaver\Testing\Http;

UnityTest::describe('AuthMiddleware', function () {

    UnityTest::test('bloqueia utilizadores não autenticados', function () {
        $response = Http::get('/perfil'); // sem sessão autenticada

        UnityTest::assertSame(302, $response->status());
        UnityTest::assertContains('/login', $response->header('Location'));
    });

    UnityTest::test('permite utilizadores autenticados', function () {
        $response = Http::actingAs($user)->get('/perfil');

        UnityTest::assertSame(200, $response->status());
    });

});

UnityTest::describe('RateLimitMiddleware', function () {

    UnityTest::test('bloqueia após exceder limite', function () {
        // Faz 61 pedidos seguidos
        for ($i = 0; $i < 61; $i++) {
            $response = Http::get('/api/dados');
        }

        UnityTest::assertSame(429, $response->status());
    });

});

UnityTest::describe('CsrfMiddleware', function () {

    UnityTest::test('rejeita POST sem token', function () {
        $response = Http::post('/form', ['name' => 'Franco']);

        UnityTest::assertSame(419, $response->status());
    });

    UnityTest::test('aceita POST com token válido', function () {
        $response = Http::withToken('valid-token')->post('/form', ['name' => 'Franco']);

        UnityTest::assertSame(200, $response->status());
    });

});</code></pre>

    <!-- 7. Ordem importa -->
    <p class="mt-4 mb-1 fw-bold">7. A ordem importa</p>
    <p class="mb-2">A ordem de execução determina o comportamento:</p>
    <div class="folder-tree">✅ CORRETO
   1. LogMiddleware         ← registar ANTES de tudo
   2. CsrfMiddleware        ← validar token
   3. AuthMiddleware        ← verificar sessão
   4. AdminMiddleware       ← verificar permissões
   → Controller

❌ ERRADO
   1. AuthMiddleware        ← verifica sessão, mas token ainda não foi validado
   2. CsrfMiddleware        ← já é tarde
   → Controller</div>

    <!-- 8. Comandos úteis -->
    <p class="mt-4 mb-1 fw-bold">8. Comandos úteis</p>
    <pre><code class="language-bash"># Criar middleware
php beaver make:middleware AuthMiddleware
php beaver make:middleware RateLimitMiddleware

# Listar middlewares registados
php beaver middleware:list

# Testar middleware específico
php beaver test tests/Feature/AuthMiddlewareTest.php</code></pre>

</div>

        </div>
        <!-- /tab-content -->

    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i> Comandos disponíveis</h2>
    <div class="beaver-card">
        <pre><code class="language-bash"># Corre todos os testes
php beaver test

# Apenas uma pasta
php beaver test tests/Unit
php beaver test tests/Feature

# Apenas um ficheiro
php beaver test tests/Unit/UserTest.php

# Filtra por nome de teste
php beaver test --filter="nome completo"

# Para no primeiro erro
php beaver test --stop-on-failure

# Com detalhes (mostra assertions)
php beaver test --verbose</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-folder-tree"></i> Estrutura recomendada</h2>
    <div class="beaver-card">
        <div class="folder-tree">meu-projeto/
├── tests/
│   ├── Unit/               # Testes isolados, sem BD nem HTTP
│   │   ├── UserTest.php
│   │   └── NewsletterTest.php
│   └── Feature/            # Testes de integração (BD + rotas)
│       ├── UserRegistrationTest.php
│       └── AuthTest.php
├── beaver                  # CLI
└── phpunit.xml             # Opcional</div>
        <p class="mt-2 mb-0 text-muted small">
            O Unity Test procura automaticamente por ficheiros <code class="inline-code">*Test.php</code>
            dentro de <code class="inline-code">tests/</code>.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-flag-checkered"></i> Boas práticas</h2>
    <div class="beaver-card">
        <ul class="mb-0">
            <li>Um ficheiro por classe/funcionalidade testada.</li>
            <li>Nomes descritivos: <code class="inline-code">test_user_can_login_with_valid_credentials</code>.</li>
            <li>Isola cada teste — não dependas da ordem de execução.</li>
            <li>Usa <code class="inline-code">describe()</code> para agrupar quando há muitos testes.</li>
            <li>Corre <code class="inline-code">php beaver test</code> antes de cada commit.</li>
        </ul>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
