<?php

/**
 * documentation.php — Beaver Framework
 * Documentação oficial: componentes, instâncias e exemplos.
 */

declare(strict_types=1);

if (!function_exists('beaver_code_lang')) {
    /**
     * Heurística simples: se vir '# ' ou um comando de shell conhecido → bash,
     * caso contrário assume php.
     */
    function beaver_code_lang(string $code): string
    {
        if (preg_match('/^\s*#\s/m', $code)) return 'bash';
        if (preg_match('/^\s*(beaver|composer|npm|yarn|pnpm|curl|wget|cd|ls|git|chmod|sudo)\b/m', $code)) return 'bash';
        return 'php';
    }
}

/* ============================================================
   Catálogo de componentes (neste ficheiro para simplicidade;
   em produção viria de /docs/index.json ou de um repositório).
   ============================================================ */
$COMPONENTS = [
    [
        'id'    => 'router',
        'name'  => 'Router',
        'icon'  => 'route',
        'tags'  => ['routing', 'http', 'core'],
        'desc'  => 'Mapeia URIs para controladores, suporta parâmetros dinâmicos, grupos, middlewares e nomes de rota.',
        'component' => <<<'PHP'
namespace Beaver\Http;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $action): Route
    {
        return $this->add('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): Route
    {
        return $this->add('POST', $uri, $action);
    }

    public function add(string $method, string $uri, $action): Route
    {
        $route = new Route($method, $uri, $action);
        $this->routes[$method][] = $route;
        return $route;
    }
}
PHP,
        'instance' => <<<'PHP'
use Beaver\Http\Router;

$router = new Router();

$router->get('/', [HomeController::class, 'index'])
       ->name('home');

$router->get('/shop/products/{id}', [ProductController::class, 'show'])
       ->where('id', '\d+')
       ->name('products.show');

$router->post('/shop/cart', [CartController::class, 'store'])
       ->middleware('csrf');
PHP,
        'example' => <<<'PHP'
// routes/web.php
$router->group(['prefix' => '/admin', 'middleware' => 'auth'], function ($r) {
    $r->get('/dashboard', [AdminController::class, 'dashboard']);
    $r->get('/users',     [AdminController::class, 'users']);
});

// No controlador:
public function show(int $id)
{
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
}
PHP,
    ],
    [
        'id'    => 'controller',
        'name'  => 'Controller',
        'icon'  => 'code',
        'tags'  => ['mvc', 'http', 'core'],
        'desc'  => 'Classe base para controladores HTTP. Injeção de dependências no construtor e helpers de resposta.',
        'component' => <<<'PHP'
namespace Beaver\Http;

abstract class Controller
{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    protected function json(array $data, int $status = 200): Response
    {
        return $this->response
            ->withStatus($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(json_encode($data));
    }
}
PHP,
        'instance' => <<<'PHP'
use Beaver\Http\Controller;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepo $products
    ) {}

    public function index(): Response
    {
        return $this->json($this->products->all());
    }

    public function show(int $id): Response
    {
        return $this->json($this->products->find($id));
    }
}
PHP,
        'example' => <<<'PHP'
class OrderController extends Controller
{
    public function store(OrderRequest $request): Response
    {
        $order = Order::create($request->validated());

        event(new OrderPlaced($order));

        return $this->json($order, 201);
    }
}
PHP,
    ],
    [
        'id'    => 'model',
        'name'  => 'Model / ORM',
        'icon'  => 'database',
        'tags'  => ['database', 'orm', 'core'],
        'desc'  => 'Active Record leve com relações, scopes, casts e eager loading nativo.',
        'component' => <<<'PHP'
namespace Beaver\Database;

abstract class Model
{
    protected string $table;
    protected array  $attributes = [];
    protected array  $casts      = [];

    public static function find(int $id): ?static
    {
        return static::query()->where('id', $id)->first();
    }

    public function __get(string $key): mixed
    {
        $value = $this->attributes[$key] ?? null;
        return isset($this->casts[$key])
            ? $this->cast($key, $value)
            : $value;
    }

    abstract public static function query(): QueryBuilder;
}
PHP,
        'instance' => <<<'PHP'
class Product extends Model
{
    protected string $table = 'products';
    protected array  $casts = [
        'price'      => 'decimal:2',
        'meta'       => 'json',
        'created_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($q): void
    {
        $q->where('active', true);
    }
}
PHP,
        'example' => <<<'PHP'
// Com eager loading (evita N+1)
$products = Product::query()
    ->with('category')
    ->active()
    ->orderBy('created_at', 'desc')
    ->paginate(20);

foreach ($products as $p) {
    echo $p->name, ' — ', $p->category->name;
}
PHP,
    ],
    [
        'id'    => 'migration',
        'name'  => 'Migrations',
        'icon'  => 'layers',
        'tags'  => ['database', 'schema', 'cli'],
        'desc'  => 'Versionamento de esquema com rollback, seeders e deteção automática de alterações.',
        'component' => <<<'PHP'
namespace Beaver\Database;

abstract class Migration
{
    abstract public function up(): void;
    abstract public function down(): void;

    protected function schema(): SchemaBuilder
    {
        return Container::get(SchemaBuilder::class);
    }
}
PHP,
        'instance' => <<<'PHP'
return new class extends Migration
{
    public function up(): void
    {
        $this->schema()->create('products', function (Table $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->decimal('price', 10, 2);
            $t->foreignId('category_id')->constrained();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema()->dropIfExists('products');
    }
};
PHP,
        'example' => <<<'BASH'
# CLI
beaver migrate
beaver migrate:rollback --steps=2
beaver migrate:fresh --seed

# Output
✔ 2024_09_19_add_slug ......... 12 ms
✔ 2024_09_19_fix_cart_fk ...... 8 ms
✔ done — 2 migrations em 20 ms
BASH,
    ],
    [
        'id'    => 'middleware',
        'name'  => 'Middleware',
        'icon'  => 'shield',
        'tags'  => ['http', 'segurança', 'core'],
        'desc'  => 'Pipeline em torno de cada pedido HTTP. Autenticação, CORS, rate limiting, CSRF.',
        'component' => <<<'PHP'
namespace Beaver\Http\Middleware;

interface Middleware
{
    public function handle(Request $request, callable $next): Response;
}
PHP,
        'instance' => <<<'PHP'
class EnsureAuthenticated implements Middleware
{
    public function handle(Request $request, callable $next): Response
    {
        if (! Auth::check($request)) {
            return redirect('/login')
                ->with('error', 'Sessão expirada.');
        }

        return $next($request);
    }
}
PHP,
        'example' => <<<'PHP'
// Registo global
$app->middleware([
    SecurityHeaders::class,
    TrimInput::class,
]);

// Por rota
$router->get('/account', [AccountController::class, 'show'])
       ->middleware([EnsureAuthenticated::class, 'verified']);
PHP,
    ],
    [
        'id'    => 'cache',
        'name'  => 'Cache',
        'icon'  => 'zap',
        'tags'  => ['performance', 'core'],
        'desc'  => 'Cache de ficheiro, Redis e Memcached com tags, TTL e cache de queries.',
        'component' => <<<'PHP'
namespace Beaver\Cache;

interface Repository
{
    public function get(string $key, mixed $default = null): mixed;
    public function put(string $key, mixed $value, int $ttl = 3600): bool;
    public function forget(string $key): bool;
    public function tags(array $names): Repository;
}
PHP,
        'instance' => <<<'PHP'
use Beaver\Cache\Cache;

// Simples
Cache::put('home.stats', $stats, ttl: 300);
$stats = Cache::get('home.stats');

// Com tags
Cache::tags(['products', 'home'])->put('featured', $list, 600);
Cache::tags(['products'])->flush();
PHP,
        'example' => <<<'PHP'
// Atributo em controlador (auto-cache)
class ProductController extends Controller
{
    #[Cache(60)]
    public function index(): Response
    {
        return $this->json(
            Product::query()->active()->get()
        );
    }
}
PHP,
    ],
    [
        'id'    => 'queue',
        'name'  => 'Queue & Jobs',
        'icon'  => 'clock',
        'tags'  => ['async', 'performance'],
        'desc'  => 'Fila de trabalhos com drivers sync/database/redis. Retries exponenciais e jobs em batch.',
        'component' => <<<'PHP'
namespace Beaver\Queue;

abstract class Job
{
    public int $tries = 3;
    public int $backoff = 5;

    abstract public function handle(): void;

    public function failed(\Throwable $e): void {}
}
PHP,
        'instance' => <<<'PHP'
class SendOrderReceipt extends Job
{
    public function __construct(
        public int $orderId
    ) {}

    public function handle(): void
    {
        $order = Order::find($this->orderId);
        Mail::to($order->email)->send(new ReceiptMail($order));
    }
}
PHP,
    'example' => <<<'PHP'
// Enfileirar
SendOrderReceipt::dispatch($order->id)
    ->onQueue('emails')
    ->delay(30);

// Worker
// beaver queue:work --queue=emails --tries=5
PHP,
    ],
    [
        'id'    => 'validation',
        'name'  => 'Validation',
        'icon'  => 'check',
        'tags'  => ['forms', 'segurança'],
        'desc'  => 'Validação declarativa com regras encadeáveis, mensagens PT e Form Requests.',
        'component' => <<<'PHP'
namespace Beaver\Validation;

class Validator
{
    public static function make(array $data, array $rules): static
    {
        return new static($data, $rules);
    }

    public function validate(): array { /* ... */ }
    public function fails(): bool    { /* ... */ }
    public function errors(): array  { /* ... */ }
}
PHP,
        'instance' => <<<'PHP'
use Beaver\Validation\Validator;

$v = Validator::make($_POST, [
    'name'  => 'required|min:3|max:80',
    'email' => 'required|email|unique:users,email',
    'age'   => 'nullable|integer|between:18,120',
]);

if ($v->fails()) {
    return $this->json(['errors' => $v->errors()], 422);
}
PHP,
        'example' => <<<'PHP'
// Form Request
class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => 'required|min:3',
            'slug'  => 'required|alpha_dash|unique:products',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return ['slug.unique' => 'Este slug já existe.'];
    }
}
PHP,
    ],
    [
        'id'    => 'sqlanalyser',
        'name'  => 'SqlAnalyser',
        'icon'  => 'search-db',
        'tags'  => ['sql', 'devtools'],
        'desc'  => 'Inspeciona queries em runtime, deteta N+1, sugere índices e mede planos de execução.',
        'component' => <<<'PHP'
namespace Beaver\DevTools\SqlAnalyser;

class Analyser
{
    private array $queries = [];

    public function listen(): void
    {
        DB::listen(function ($q) {
            $this->queries[] = [
                'sql'  => $q->sql,
                'time' => $q->time,
                'bind' => $q->bindings,
            ];
        });
    }

    public function slow(int $ms = 100): array { /* ... */ }
    public function suggestIndexes(): array    { /* ... */ }
}
PHP,
        'instance' => <<<'PHP'
use Beaver\DevTools\SqlAnalyser\Analyser;

$analyser = new Analyser();
$analyser->listen();

// ... corre a aplicação ...

$report = $analyser->slow(100);
foreach ($report as $q) {
    echo $q['time'], ' ms · ', $q['sql'];
}
PHP,
        'example' => <<<'BASH'
# CLI
beaver sql:analyse --since=10m

# Output
▲ N+1 detetado: OrderController@show (47 queries)
◆ Sugestão: criar índice idx_products_slug (−63% tempo)
◆ Sugestão: usar eager loading em ProductController@index
✔ 0 queries acima de 100 ms
BASH,
    ],
    [
        'id'    => 'frankey',
        'name'  => 'Frankey',
        'icon'  => 'key',
        'tags'  => ['auth', 'segurança'],
        'desc'  => 'Autenticação e sessões. Tokens, 2FA, recuperação de palavra-passe e gestão de dispositivos.',
        'component' => <<<'PHP'
namespace Beaver\Auth;

class Frankey
{
    public function attempt(string $email, string $password): bool;
    public function login(User $user, bool $remember = false): void;
    public function logout(): void;
    public function user(): ?User;
    public function token(User $user): string;
}
PHP,
        'instance' => <<<'PHP'
use Beaver\Auth\Frankey;

$auth = new Frankey();

if ($auth->attempt($email, $password)) {
    return redirect()->intended('/dashboard');
}

// Token para API
$token = $auth->token($user);
PHP,
        'example' => <<<'PHP'
// Middleware
$router->get('/account', fn () => view('account'))
       ->middleware('auth');

// 2FA
$auth->requireTwoFactor($user);
if (! $auth->verifyCode($user, $code)) {
    return back()->with('error', 'Código inválido.');
}
PHP,
    ],
    [
        'id'    => 'events',
        'name'  => 'Events & Listeners',
        'icon'  => 'bell',
        'tags'  => ['arquitetura', 'core'],
        'desc'  => 'Sistema de eventos desacoplado com listeners síncronos e assíncronos.',
        'component' => <<<'PHP'
namespace Beaver\Events;

class Dispatcher
{
    private array $listeners = [];

    public function listen(string $event, callable|string $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function dispatch(object $event): void
    {
        foreach ($this->listeners[$event::class] ?? [] as $l) {
            Container::call($l, [$event]);
        }
    }
}
PHP,
        'instance' => <<<'PHP'
class OrderPlaced
{
    public function __construct(
        public Order $order
    ) {}
}

class SendReceiptListener
{
    public function handle(OrderPlaced $event): void
    {
        SendOrderReceipt::dispatch($event->order->id);
    }
}
PHP,
        'example' => <<<'PHP'
// Registo
Event::listen(OrderPlaced::class, SendReceiptListener::class);
Event::listen(OrderPlaced::class, UpdateStockListener::class);

// Disparo
event(new OrderPlaced($order));
PHP,
    ],
    [
        'id'    => 'cli',
        'name'  => 'CLI · beaver',
        'icon'  => 'terminal',
        'tags'  => ['cli', 'devtools'],
        'desc'  => 'Ferramenta de linha de comandos para scaffolding, build, migrações e diagnóstico.',
        'component' => <<<'BASH'
beaver <comando> [opções]

Comandos disponíveis:
  make:controller   make:model     make:migration
  make:middleware   make:job       make:listener
  migrate           migrate:fresh  migrate:rollback
  build             build --watch  serve
  queue:work        cache:clear    sql:analyse
  test              lint           doctor
BASH,
        'instance' => <<<'BASH'
# Criar scaffolding
beaver make:controller ProductController --resource
beaver make:model Product -m    # com migration
beaver make:job SendOrderReceipt

# Correr
beaver serve --host=0.0.0.0 --port=8080
beaver build --watch
beaver test --coverage
BASH,
        'example' => <<<'BASH'
beaver doctor

✔ PHP 8.3.10
✔ ext-pdo_sqlite
✔ ext-mbstring
✔ Writable: storage/ logs/
▲ Redis indisponível — cache em ficheiro ativa
✔ 0 problemas críticos
BASH,
    ],
];

/* Paginação (server-side simples, aqui em memória) */
$perPage   = 6;
$page      = max(1, (int)($_GET['page'] ?? 1));
$total     = count($COMPONENTS);
$pages     = max(1, (int)ceil($total / $perPage));
$page      = min($page, $pages);
$offset    = ($page - 1) * $perPage;
$pageItems = array_slice($COMPONENTS, $offset, $perPage);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Documentação — Beaver Framework 🦫</title>
<meta name="description" content="Documentação oficial do Beaver Framework: componentes, instâncias e exemplos.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<!-- Prism — core + linguagens -->
<script defer src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-markup-templating.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-php.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-bash.min.js"></script>
<link rel="stylesheet" href="/resources/ui/css/documentation.css">
</head>
<body class="docs-page">

<!-- ============ ICONS SPRITE ============ -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#FFE7BE"/>
      <stop offset="48%" stop-color="#F5A623"/>
      <stop offset="100%" stop-color="#E07800"/>
    </linearGradient>
    <symbol id="beaver" viewBox="0 0 64 64">
      <circle cx="13" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <circle cx="51" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <ellipse cx="32" cy="33" rx="23" ry="21" fill="url(#bvg)"/>
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#8A4A00" opacity=".28"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#2B1606"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="41.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="23.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <circle cx="42.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
    </symbol>

    <symbol id="ico-home" viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/></symbol>
    <symbol id="ico-book" viewBox="0 0 24 24"><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 0 4 22.5V4.5z"/><path d="M4 4.5A2.5 2.5 0 0 0 6.5 7H20"/></symbol>
    <symbol id="ico-gh" viewBox="0 0 24 24"><path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/></symbol>
    <symbol id="ico-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></symbol>

    <symbol id="ico-route" viewBox="0 0 24 24"><circle cx="6" cy="19" r="2.5"/><circle cx="18" cy="5" r="2.5"/><path d="M8.5 19h5a4 4 0 0 0 0-8h-3a4 4 0 0 1 0-8"/></symbol>
    <symbol id="ico-code" viewBox="0 0 24 24"><path d="M9 18l-6-6 6-6"/><path d="M15 6l6 6-6 6"/></symbol>
    <symbol id="ico-database" viewBox="0 0 24 24"><ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v6c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/><path d="M4 12v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/></symbol>
    <symbol id="ico-layers" viewBox="0 0 24 24"><path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M3 13l9 5 9-5"/></symbol>
    <symbol id="ico-shield" viewBox="0 0 24 24"><path d="M12 2l9 4v6c0 5-3.6 8.7-9 10-5.4-1.3-9-5-9-10V6l9-4z"/></symbol>
    <symbol id="ico-zap" viewBox="0 0 24 24"><path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/></symbol>
    <symbol id="ico-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="ico-check" viewBox="0 0 24 24"><path d="M5 13l4 4 10-10"/></symbol>
    <symbol id="ico-search-db" viewBox="0 0 24 24"><ellipse cx="11" cy="6" rx="7" ry="3"/><path d="M4 6v6c0 1.5 3.1 2.7 7 2.7"/><path d="M20 20l-3-3"/><circle cx="16" cy="15" r="3"/></symbol>
    <symbol id="ico-key" viewBox="0 0 24 24"><circle cx="8" cy="15" r="4"/><path d="M11 12l9-9 3 3-3 3 2 2-3 3-2-2-3 3"/></symbol>
    <symbol id="ico-bell" viewBox="0 0 24 24"><path d="M6 16V11a6 6 0 0 1 12 0v5l2 2H4l2-2z"/><path d="M10 20a2 2 0 0 0 4 0"/></symbol>
    <symbol id="ico-terminal" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9l3 3-3 3"/><path d="M13 15h4"/></symbol>
    <symbol id="ico-copy" viewBox="0 0 24 24"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></symbol>
    <symbol id="ico-chev-l" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></symbol>
    <symbol id="ico-chev-r" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></symbol>
  </defs>
</svg>

<!-- ============ HEADER ============ -->
<?php
$active  = 'documentation';
$version = $version ?? beaver_version();
require __DIR__ . '/partials/header-docs.php';
?>

<!-- ============ HERO ============ -->
<section class="hero">
  <h1>
    Documentação
    <span class="badge">v1.0 · <?= date('Y') ?></span>
  </h1>
  <p>
    Referência completa dos componentes do Beaver Framework. Cada entrada inclui a
    <strong>assinatura do componente</strong>, uma <strong>instância pronta a usar</strong>
    e um <strong>exemplo real</strong> de integração.
  </p>
</section>

<!-- ============ FILTROS ============ -->
<div class="filters-wrap">
  <div class="filters" role="search">
    <label class="search">
      <svg aria-hidden="true"><use href="#ico-search"/></svg>
      <input
        id="q"
        type="search"
        placeholder="Pesquisar componente, tag ou descrição…"
        autocomplete="off"
        aria-label="Pesquisar na documentação"
      >
    </label>

    <div class="filter-tags" id="tags" role="group" aria-label="Filtrar por categoria">
      <button class="tag-btn active" data-tag="all" type="button">Tudo</button>
      <button class="tag-btn" data-tag="core" type="button">Core</button>
      <button class="tag-btn" data-tag="database" type="button">Database</button>
      <button class="tag-btn" data-tag="http" type="button">HTTP</button>
      <button class="tag-btn" data-tag="segurança" type="button">Segurança</button>
      <button class="tag-btn" data-tag="performance" type="button">Performance</button>
      <button class="tag-btn" data-tag="devtools" type="button">DevTools</button>
      <button class="tag-btn" data-tag="cli" type="button">CLI</button>
    </div>

    <span class="filter-count" id="count"><b><?= $total ?></b> componentes</span>
  </div>
</div>

<!-- ============ LISTA ============ -->
<section class="list" id="list">
  <?php foreach ($pageItems as $i => $c) : ?>
  <article
    class="card"
    data-id="<?= htmlspecialchars($c['id']) ?>"
    data-tags="<?= htmlspecialchars(implode(' ', $c['tags'])) ?>"
    data-name="<?= htmlspecialchars($c['name']) ?>"
    data-desc="<?= htmlspecialchars($c['desc']) ?>"
    style="animation-delay:<?= $i * 40 ?>ms"
  >
    <header class="card-head">
      <span class="card-ico" aria-hidden="true">
        <svg><use href="#ico-<?= htmlspecialchars($c['icon']) ?>"/></svg>
      </span>
      <div class="card-info">
        <div class="card-title-row">
          <h2 class="card-title"><?= htmlspecialchars($c['name']) ?></h2>
          <span class="card-id"><?= htmlspecialchars($c['id']) ?></span>
        </div>
        <p class="card-desc"><?= htmlspecialchars($c['desc']) ?></p>
        <div class="card-tags">
          <?php foreach ($c['tags'] as $t) : ?>
            <span class="t"><?= htmlspecialchars($t) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </header>

    <div class="tabs" role="tablist" aria-label="Vistas do componente <?= htmlspecialchars($c['name']) ?>">
      <button class="tab active" role="tab" aria-selected="true" data-pane="component" type="button">
        <svg aria-hidden="true"><use href="#ico-code"/></svg>
        Componente
      </button>
      <button class="tab" role="tab" aria-selected="false" data-pane="instance" type="button">
        <svg aria-hidden="true"><use href="#ico-layers"/></svg>
        Instância
      </button>
      <button class="tab" role="tab" aria-selected="false" data-pane="example" type="button">
        <svg aria-hidden="true"><use href="#ico-check"/></svg>
        Exemplo
      </button>
    </div>

    <div class="panes">
      <div class="pane active" data-pane="component" role="tabpanel">
        <div class="code-block">
          <div class="code-head">
            <span class="code-lang"><i></i> PHP · definição</span>
            <button class="copy-btn" type="button" data-copy>
              <svg aria-hidden="true"><use href="#ico-copy"/></svg> copiar
            </button>
          </div>
         <pre><code class="language-<?= beaver_code_lang($c['component']) ?>"><?= htmlspecialchars(trim($c['component'])) ?></code></pre>
        </div>
      </div>

      <div class="pane" data-pane="instance" role="tabpanel">
        <div class="code-block">
          <div class="code-head">
            <span class="code-lang"><i></i> PHP · instância</span>
            <button class="copy-btn" type="button" data-copy>
              <svg aria-hidden="true"><use href="#ico-copy"/></svg> copiar
            </button>
          </div>
         <pre><code class="language-<?= beaver_code_lang($c['component']) ?>"><?= htmlspecialchars(trim($c['component'])) ?></code></pre>
        </div>
      </div>

      <div class="pane" data-pane="example" role="tabpanel">
        <div class="code-block">
          <div class="code-head">
            <span class="code-lang"><i></i> Exemplo</span>
            <button class="copy-btn" type="button" data-copy>
              <svg aria-hidden="true"><use href="#ico-copy"/></svg> copiar
            </button>
          </div>
         <pre><code class="language-<?= beaver_code_lang($c['component']) ?>"><?= htmlspecialchars(trim($c['component'])) ?></code></pre>
        </div>
      </div>
    </div>
  </article>
  <?php endforeach; ?>

  <div class="empty" id="empty">
    <div class="ico"><svg aria-hidden="true"><use href="#ico-search"/></svg></div>
    <strong>Sem resultados</strong>
    <span>Tenta outro termo ou remove os filtros ativos.</span>
  </div>
</section>

<!-- ============ PAGINAÇÃO ============ -->
<?php if ($pages > 1) : ?>
<nav class="pagination" aria-label="Paginação">
  <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>"
     href="?page=<?= max(1, $page - 1) ?>"
     aria-label="Página anterior"
     <?= $page <= 1 ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
    <svg aria-hidden="true"><use href="#ico-chev-l"/></svg>
  </a>

    <?php for ($p = 1; $p <= $pages; $p++) : ?>
    <a class="page-num <?= $p === $page ? 'active' : '' ?>"
       href="?page=<?= $p ?>"
        <?= $p === $page ? 'aria-current="page"' : '' ?>>
        <?= $p ?>
    </a>
    <?php endfor; ?>

  <a class="page-btn <?= $page >= $pages ? 'disabled' : '' ?>"
     href="?page=<?= min($pages, $page + 1) ?>"
     aria-label="Página seguinte"
     <?= $page >= $pages ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
    <svg aria-hidden="true"><use href="#ico-chev-r"/></svg>
  </a>
</nav>
<?php endif; ?>

<!-- ============ FOOTER ============ -->
<footer>
  © <span id="ano"></span> Beaver Framework · Feito com <span class="accent">🦫</span> em Portugal
</footer>

<script>
/* ============================================================
   Tabs por cartão
   ============================================================ */
document.querySelectorAll('.card').forEach(card => {
  const tabs  = card.querySelectorAll('.tab');
  const panes = card.querySelectorAll('.pane');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const target = tab.dataset.pane;

      tabs.forEach(t => {
        const on = t === tab;
        t.classList.toggle('active', on);
        t.setAttribute('aria-selected', on ? 'true' : 'false');
      });

      panes.forEach(p => {
        p.classList.toggle('active', p.dataset.pane === target);
      });
    });
  });
});

/* ============================================================
   Copiar código
   ============================================================ */
document.querySelectorAll('[data-copy]').forEach(btn => {
  btn.addEventListener('click', async () => {
    const pre = btn.closest('.code-block').querySelector('pre');
    try {
      await navigator.clipboard.writeText(pre.textContent);
      const old = btn.innerHTML;
      btn.classList.add('ok');
      btn.innerHTML = '<svg aria-hidden="true"><use href="#ico-check"/></svg> copiado';
      setTimeout(() => {
        btn.classList.remove('ok');
        btn.innerHTML = old;
      }, 1400);
    } catch {
      /* fallback silencioso */
    }
  });
});

/* ============================================================
   Filtro + Pesquisa (client-side)
   ============================================================ */
const q        = document.getElementById('q');
const tagsWrap = document.getElementById('tags');
const list     = document.getElementById('list');
const empty    = document.getElementById('empty');
const count    = document.getElementById('count');
const cards    = Array.from(document.querySelectorAll('.card'));

let activeTag = 'all';

function normalize(str) {
  return (str || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');
}

function applyFilters() {
  const term = normalize(q.value.trim());
  let visible = 0;

  cards.forEach(card => {
    const haystack = normalize(
      card.dataset.name + ' ' + card.dataset.desc + ' ' + card.dataset.tags + ' ' + card.dataset.id
    );
    const tags = card.dataset.tags.split(/\s+/);

    const matchTerm = !term || haystack.includes(term);
    const matchTag  = activeTag === 'all' || tags.includes(activeTag);

    const show = matchTerm && matchTag;
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  empty.classList.toggle('show', visible === 0);
  count.innerHTML = `<b>${visible}</b> componente${visible === 1 ? '' : 's'}`;
}

q.addEventListener('input', applyFilters);

tagsWrap.addEventListener('click', e => {
  const btn = e.target.closest('.tag-btn');
  if (!btn) return;

  tagsWrap.querySelectorAll('.tag-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  activeTag = btn.dataset.tag;
  applyFilters();
});

/* Ano no footer */
document.getElementById('ano').textContent = new Date().getFullYear();
</script>
</body>
</html>
