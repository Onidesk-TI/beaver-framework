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

// routes/web.php — rotas do core do Beaver

use Beaver\Http\Response;
use Beaver\Http\Router;

$router = Router::current();

// ── Helper: servir assets do core ──
if (!function_exists('beaver_core_serve_asset')) {
    function beaver_core_serve_asset(string $folder, string $file): Response
    {
        if (
            !preg_match('/^[A-Za-z0-9_-]+$/', $folder) ||
            !preg_match('/^[A-Za-z0-9_.-]+$/', $file)
        ) {
            return Response::text('Forbidden', 403);
        }

        $path = dirname(__DIR__) . '/resources/ui/' . $folder . '/' . $file;

        if (!is_file($path)) {
            return Response::text('Not found: ' . $path, 404);
        }

        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        $mime = match ($ext) {
            'css'   => 'text/css; charset=utf-8',
            'js'    => 'application/javascript; charset=utf-8',
            'svg'   => 'image/svg+xml',
            'png'   => 'image/png',
            'jpg',
            'jpeg'  => 'image/jpeg',
            'webp'  => 'image/webp',
            'woff2' => 'font/woff2',
            'woff'  => 'font/woff',
            'ttf'   => 'font/ttf',
            default => 'application/octet-stream',
        };

        return (new Response(file_get_contents($path)))
            ->withHeader('Content-Type', $mime)
            ->withHeader('Cache-Control', 'public, max-age=3600');
    }
}

// ── Documentação ──
$router->get('/documentation', function () {
    return beaver_marketplace_view('documentation', [
        'title'   => 'Documentação · Beaver Framework',
        'version' => \Beaver\Foundation\Application::VERSION,
        'year'    => date('Y'),
    ]);
});

// ── Assets do core ──
$router->get('/resources/ui/css/{file}', function ($req, $file) {
    return beaver_core_serve_asset('css', (string) $file);
});

$router->get('/resources/ui/js/{file}', function ($req, $file) {
    return beaver_core_serve_asset('js', (string) $file);
});

// ── Landing do Beaver ──
// ── Beaver SDK ──
$router->get('/sdk', function () {
    $view = dirname(__DIR__) . '/app/views/sdk.php';

    if (!is_file($view)) {
        return Response::text('View não encontrada: ' . $view, 404);
    }

    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});
$router->get('/', function () {
    $view = dirname(__DIR__) . '/app/views/index.php';

    if (!is_file($view)) {
        return Response::text('View não encontrada: ' . $view, 404);
    }

    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});

// Rota de teste rápida
$router->get('/hello', function () {
    return Response::html('<h1>🦫 Beaver Framework</h1><p>Está vivo! v' . \Beaver\Foundation\Application::VERSION . '</p>');
});

// Rota de diagnóstico
$router->get('/ping', function () {
    return Response::json([
        'ok'      => true,
        'time'    => date('c'),
        'version' => \Beaver\Foundation\Application::VERSION,
    ]);
});

// Debug: estado dos plugins
$router->get('/_plugins', function () {
    $pm = app()->make(\Beaver\Plugin\PluginManager::class);
    return Response::json([
        'mode'       => $pm->mode(),
        'dev_path'   => config('app.plugins.dev_path'),
        'prod_path'  => config('app.plugins.path'),
        'manifests'  => $pm->manifests(),
    ]);
});

// ── Assets: css ──
$router->get('/resources/ui/css/{file}', function ($req, $file) {
    return beaver_core_serve_asset('css', (string) $file);
});

// ── Assets: js ──
$router->get('/resources/ui/js/{file}', function ($req, $file) {
    return beaver_core_serve_asset('js', (string) $file);
});

// ── Screenshots de plugins ──
$router->get('/plugins/{slug}/screenshot/{file}', function ($req, $slug, $file) {
    $slug = (string) $slug;
    $file = (string) $file;

    if (!preg_match('/^[a-z0-9_-]+$/i', $slug) ||
        !preg_match('/^[A-Za-z0-9_.-]+$/', $file)) {
        return Response::text('Forbidden', 403);
    }

    $base = dirname(__DIR__);
    $candidates = [
        "$base/plugins/$slug/resources/screenshots/$file",
        "$base/app/plugins/$slug/resources/screenshots/$file",
    ];

    foreach ($candidates as $path) {
        if (!is_file($path)) {
            continue;
        }

        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'png'         => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp'        => 'image/webp',
            'gif'         => 'image/gif',
            'svg'         => 'image/svg+xml',
            default       => 'application/octet-stream',
        };

        return Response::html((string) file_get_contents($path), 200)
            ->withHeader('Content-Type', $mime)
            ->withHeader('Cache-Control', 'public, max-age=86400');
    }

    return Response::text('Screenshot not found', 404);
});
// ── Plugins ──
$router->get('/plugins', function () {
    $view = dirname(__DIR__) . '/app/views/plugins.php';

    if (!is_file($view)) {
        return Response::text('View não encontrada: ' . $view, 404);
    }

    $plugins = [
        [
            'name'        => 'Beaver Console',
            'slug'        => 'beaver-console',
            'icon'        => '⌨️',
            'hue'         => 260,
            'official'    => true,
            'version'     => '1.2.0',
            'author'      => 'Onidesk',
            'category'    => 'devtools',
            'category_label' => 'Ferramentas dev',
            'tags'        => ['official', 'stable'],
            'repo'        => 'https://github.com/Onidesk-TI/beaver-console',
            'composer'    => 'onidesk-ti/beaver-console',
            'description' => 'REPL interativo, comandos Artisan-style e inspector de rotas. O canivete suíço do dia a dia.',
            'stars'       => 342,
            'downloads'   => 12840,
            'updated'     => 'há 3 dias',
            'updated_ts'  => 1726900000,
            'screenshot'  => '/plugins/console/screenshots/cover.png',
            'usage'       => "php beaver console\n> routes:list\n> make:controller ProductController",
        ],
        [
            'name'           => 'Beaver Skeleton',
            'slug'           => 'beaver-skeleton',
            'icon'           => '🦴',
            'hue'            => 30,
            'official'       => true,
            'version'        => '0.1.0',
            'author'         => 'Onidesk',
            'category'       => 'devtools',
            'category_label' => 'Ferramentas dev',
            'tags'           => ['official', 'stable', 'new'],
            'repo'           => 'https://github.com/Onidesk-TI/beaver-skeleton',
            'composer'       => 'onidesk-ti/beaver-skeleton',
            'description'    => 'Esqueleto oficial para criar plugins.',
            'stars'          => 0,
            'downloads'      => 0,
            'updated'        => 'agora',
            'updated_ts'     => 1730000000,
            'screenshot'     => '/plugins/beaver-skeleton/screenshots/cover.png',
            'usage'          => "composer create-project onidesk/beaver-skeleton",
        ],
        [
            'name'        => 'Frankey',
            'slug'        => 'frankey',
            'icon'        => '🔐',
            'hue'         => 280,
            'official'    => true,
            'version'     => '0.9.4',
            'author'      => 'Onidesk',
            'category'    => 'auth',
            'category_label' => 'Autenticação',
            'tags'        => ['official', 'stable'],
            'repo'        => 'https://github.com/Onidesk-TI/frankeiphp',
            'composer'    => 'onidesk-ti/frankey',
            'description' => 'Autenticação, sessões, JWT e 2FA. PSR-15, sem magia, com eventos.',
            'stars'       => 218,
            'downloads'   => 8320,
            'updated'     => 'há 1 semana',
            'updated_ts'  => 1726400000,
            'screenshot'  => null,
            'usage'       => "use Beaver\\Frankey\\Auth;\n\nAuth::attempt(\$email, \$password);",
        ],
        [
            'name'        => 'SqlAnalyser',
            'slug'        => 'sqlanalyser',
            'icon'        => '🗄️',
            'hue'         => 150,
            'official'    => true,
            'version'     => '2.1.0',
            'author'      => 'Onidesk',
            'category'    => 'database',
            'category_label' => 'Base de dados',
            'tags'        => ['official', 'stable'],
            'repo'        => 'https://github.com/Onidesk-TI/sqlanalyser',
            'composer'    => 'onidesk-ti/sqlanalyser',
            'description' => 'Inspetor de queries em tempo real. Detecta N+1, sugere índices e mostra o plano de execução.',
            'stars'       => 456,
            'downloads'   => 15230,
            'updated'     => 'há 2 dias',
            'updated_ts'  => 1727000000,
            'screenshot'  => null,
            'usage'       => "SqlAnalyser::watch(function (\$query) {\n    logger()->debug(\$query->sql());\n});",
        ],
        [
            'name'        => 'Beaver Mail',
            'slug'        => 'beaver-mail',
            'icon'        => '✉️',
            'hue'         => 20,
            'version'     => '1.0.2',
            'author'      => 'Onidesk',
            'category'    => 'mail',
            'category_label' => 'Email',
            'tags'        => ['stable'],
            'repo'        => 'https://github.com/Onidesk-TI/beaver-mail',
            'composer'    => 'onidesk-ti/beaver-mail',
            'description' => 'Envio de email com templates Twig-like, filas e preview em browser.',
            'stars'       => 134,
            'downloads'   => 5210,
            'updated'     => 'há 3 semanas',
            'updated_ts'  => 1725400000,
            'screenshot'  => null,
            'usage'       => "Mail::to('user@example.com')\n    ->subject('Bem-vindo')\n    ->template('welcome', ['name' => \$user->name])\n    ->send();",
        ],
        [
            'name'        => 'Beaver Queue',
            'slug'        => 'beaver-queue',
            'icon'        => '⚙️',
            'hue'         => 200,
            'version'     => '0.8.0',
            'author'      => 'Comunidade',
            'category'    => 'queue',
            'category_label' => 'Filas & Jobs',
            'tags'        => ['beta'],
            'repo'        => 'https://github.com/Onidesk-TI/beaver-queue',
            'composer'    => 'onidesk-ti/beaver-queue',
            'description' => 'Jobs em background com drivers Redis, Database e Sync. Retry, prioridade e delayed dispatch.',
            'stars'       => 89,
            'downloads'   => 2140,
            'updated'     => 'ontem',
            'updated_ts'  => 1727100000,
            'screenshot'  => null,
            'usage'       => "Queue::push(new SendWelcomeEmail(\$userId));",
        ],
        [
            'name'        => 'Beaver Storage',
            'slug'        => 'beaver-storage',
            'icon'        => '💾',
            'hue'         => 40,
            'version'     => '1.1.0',
            'author'      => 'Onidesk',
            'category'    => 'storage',
            'category_label' => 'Storage',
            'tags'        => ['official', 'stable'],
            'repo'        => 'https://github.com/Onidesk-TI/beaver-storage',
            'composer'    => 'onidesk-ti/beaver-storage',
            'description' => 'Abstração de filesystem: local, S3, GCS, Azure. Uploads, URLs assinadas e streaming.',
            'stars'       => 203,
            'downloads'   => 6720,
            'updated'     => 'há 5 dias',
            'updated_ts'  => 1726800000,
            'screenshot'  => null,
            'usage'       => "Storage::disk('s3')->put('avatars/1.jpg', \$contents);",
        ],
        [
            'name'        => 'Beaver Admin',
            'slug'        => 'beaver-admin',
            'icon'        => '⚙️',
            'hue'         => 30,
            'version'     => '0.1.0',
            'author'      => 'Onidesk',
            'category'    => 'admin',
            'category_label' => 'Admin & UI',
            'tags'        => ['official', 'stable', 'new'],
            'repo'        => 'https://github.com/Onidesk-TI/beaver-admin',
            'composer'    => 'onidesk-ti/beaver-admin',
            'description' => 'Dashboard de administração com autenticação, notas e gestão do sistema.',
            'stars'       => 0,
            'downloads'   => 0,
            'updated'     => 'agora',
            'updated_ts'  => 1730000000,
            'screenshot'  => '/plugins/beaver-admin/screenshots/cover.png',
            'usage'       => "GET /admin (protegido)\nPOST /login\nPOST /register",
        ],
        [
            'name'        => 'Beaver Logs',
            'slug'        => 'beaver-logs',
            'icon'        => '📋',
            'hue'         => 10,
            'version'     => '1.0.0',
            'author'      => 'Comunidade',
            'category'    => 'devtools',
            'category_label' => 'Ferramentas dev',
            'tags'        => ['stable', 'new'],
            'repo'        => 'https://github.com/Onidesk-TI/beaver-logs',
            'composer'    => 'onidesk-ti/beaver-logs',
            'description' => 'Visualizador de logs com filtros por nível, canal e data. Tail em tempo real no browser.',
            'stars'       => 112,
            'downloads'   => 3450,
            'updated'     => 'há 4 dias',
            'updated_ts'  => 1726700000,
            'screenshot'  => null,
            'usage'       => "// config/logs.php\n'channels' => ['app', 'sql', 'mail'],",
        ],
    ];

    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});

// ═══════════════════════════════════════════════════════════
//  marketplace — página de compra/venda de plugins, temas, serviços
// ═══════════════════════════════════════════════════════════

// ── Dados de exemplo (substitui por BD quando tiveres models) ──
if (!function_exists('beaver_marketplace_products')) {
    function beaver_marketplace_products(): array
    {
        return [
    // ═══ GRÁTIS ═══
        [
        'name'        => 'Beaver Console',
        'slug'        => 'beaver-console',
        'icon'        => '⌨️',
        'hue'         => 260,
        'official'    => true,
        'version'     => '1.2.0',
        'author'      => 'Onidesk',
        'category'    => 'devtools',
        'category_label' => 'Ferramentas dev',
        'tags'        => ['official', 'stable'],
        'repo'        => 'https://github.com/Onidesk-TI/beaver-console',
        'composer'    => 'onidesk-ti/beaver-console',
        'description' => 'REPL interativo, comandos Artisan-style e inspector de rotas. O canivete suíço do dia a dia.',
        'stars'       => 342,
        'downloads'   => 12840,
        'updated'     => 'há 3 dias',
        'updated_ts'  => 1726900000,
        'screenshot'  => '/plugins/console/screenshots/cover.png',
        'usage'       => "php beaver console\n> routes:list\n> make:controller ProductController",
        'price'       => 0,
        'is_free'     => true,
        ],
        [
        'name'        => 'Frankey',
        'slug'        => 'frankey',
        'icon'        => '🔐',
        'hue'         => 280,
        'official'    => true,
        'version'     => '0.9.4',
        'author'      => 'Onidesk',
        'category'    => 'auth',
        'category_label' => 'Autenticação',
        'tags'        => ['official', 'stable'],
        'repo'        => 'https://github.com/Onidesk-TI/frankeiphp',
        'composer'    => 'onidesk-ti/frankey',
        'description' => 'Autenticação, sessões, JWT e 2FA. PSR-15, sem magia, com eventos.',
        'stars'       => 218,
        'downloads'   => 8320,
        'updated'     => 'há 1 semana',
        'updated_ts'  => 1726400000,
        'screenshot'  => null,
        'usage'       => "use Beaver\\Frankey\\Auth;\n\nAuth::attempt(\$email, \$password);",
        'price'       => 0,
        'is_free'     => true,
        ],
        [
        'name'        => 'SqlAnalyser',
        'slug'        => 'sqlanalyser',
        'icon'        => '🗄️',
        'hue'         => 150,
        'official'    => true,
        'version'     => '2.1.0',
        'author'      => 'Onidesk',
        'category'    => 'database',
        'category_label' => 'Base de dados',
        'tags'        => ['official', 'stable'],
        'repo'        => 'https://github.com/Onidesk-TI/sqlanalyser',
        'composer'    => 'onidesk-ti/sqlanalyser',
        'description' => 'Inspetor de queries em tempo real. Detecta N+1, sugere índices e mostra o plano de execução.',
        'stars'       => 456,
        'downloads'   => 15230,
        'updated'     => 'há 2 dias',
        'updated_ts'  => 1727000000,
        'screenshot'  => null,
        'usage'       => "SqlAnalyser::watch(function (\$query) {\n    logger()->debug(\$query->sql());\n});",
        'price'       => 0,
        'is_free'     => true,
        ],
        [
        'name'        => 'Beaver Logs',
        'slug'        => 'beaver-logs',
        'icon'        => '📋',
        'hue'         => 10,
        'version'     => '1.0.0',
        'author'      => 'Comunidade',
        'category'    => 'devtools',
        'category_label' => 'Ferramentas dev',
        'tags'        => ['stable', 'new'],
        'repo'        => 'https://github.com/Onidesk-TI/beaver-logs',
        'composer'    => 'onidesk-ti/beaver-logs',
        'description' => 'Visualizador de logs com filtros por nível, canal e data. Tail em tempo real no browser.',
        'stars'       => 112,
        'downloads'   => 3450,
        'updated'     => 'há 4 dias',
        'updated_ts'  => 1726700000,
        'screenshot'  => null,
        'usage'       => "// config/logs.php\n'channels' => ['app', 'sql', 'mail'],",
        'price'       => 0,
        'is_free'     => true,
        ],

    // ═══ PREMIUM ═══
        [
        'name'        => 'Beaver Mail',
        'slug'        => 'beaver-mail',
        'icon'        => '✉️',
        'hue'         => 20,
        'version'     => '1.0.2',
        'author'      => 'Onidesk',
        'category'    => 'mail',
        'category_label' => 'Email',
        'tags'        => ['stable'],
        'repo'        => 'https://github.com/Onidesk-TI/beaver-mail',
        'composer'    => 'onidesk-ti/beaver-mail',
        'description' => 'Envio de email com templates Twig-like, filas e preview em browser.',
        'stars'       => 134,
        'downloads'   => 5210,
        'updated'     => 'há 3 semanas',
        'updated_ts'  => 1725400000,
        'screenshot'  => null,
        'usage'       => "Mail::to('user@example.com')\n    ->subject('Bem-vindo')\n    ->template('welcome', ['name' => \$user->name])\n    ->send();",
        'price'       => 19.00,
        'is_free'     => false,
        ],
        [
        'name'        => 'Beaver Queue',
        'slug'        => 'beaver-queue',
        'icon'        => '⚙️',
        'hue'         => 200,
        'version'     => '0.8.0',
        'author'      => 'Comunidade',
        'category'    => 'queue',
        'category_label' => 'Filas & Jobs',
        'tags'        => ['beta'],
        'repo'        => 'https://github.com/Onidesk-TI/beaver-queue',
        'composer'    => 'onidesk-ti/beaver-queue',
        'description' => 'Jobs em background com drivers Redis, Database e Sync. Retry, prioridade e delayed dispatch.',
        'stars'       => 89,
        'downloads'   => 2140,
        'updated'     => 'ontem',
        'updated_ts'  => 1727100000,
        'screenshot'  => null,
        'usage'       => "Queue::push(new SendWelcomeEmail(\$userId));",
        'price'       => 39.00,
        'is_free'     => false,
        ],
        [
        'name'        => 'Beaver Storage',
        'slug'        => 'beaver-storage',
        'icon'        => '💾',
        'hue'         => 40,
        'version'     => '1.1.0',
        'author'      => 'Onidesk',
        'category'    => 'storage',
        'category_label' => 'Storage',
        'tags'        => ['official', 'stable'],
        'repo'        => 'https://github.com/Onidesk-TI/beaver-storage',
        'composer'    => 'onidesk-ti/beaver-storage',
        'description' => 'Abstração de filesystem: local, S3, GCS, Azure. Uploads, URLs assinadas e streaming.',
        'stars'       => 203,
        'downloads'   => 6720,
        'updated'     => 'há 5 dias',
        'updated_ts'  => 1726800000,
        'screenshot'  => null,
        'usage'       => "Storage::disk('s3')->put('avatars/1.jpg', \$contents);",
        'price'       => 25.00,
        'is_free'     => false,
        ],
        [
        'name'        => 'Beaver Admin',
        'slug'        => 'beaver-admin',
        'icon'        => '⚙️',
        'hue'         => 30,
        'version'     => '0.1.0',
        'author'      => 'Onidesk',
        'category'    => 'admin',
        'category_label' => 'Admin & UI',
        'tags'        => ['official', 'stable', 'new'],
        'repo'        => 'https://github.com/Onidesk-TI/beaver-admin',
        'composer'    => 'onidesk-ti/beaver-admin',
        'description' => 'Dashboard de administração com autenticação, notas e gestão do sistema.',
        'stars'       => 0,
        'downloads'   => 0,
        'updated'     => 'agora',
        'updated_ts'  => 1730000000,
        'screenshot'  => '/plugins/beaver-admin/screenshots/cover.png',
        'usage'       => "GET /admin (protegido)\nPOST /login\nPOST /register",
        'price'       => 49.00,
        'is_free'     => false,
        ],
        ];
    }
}

if (!function_exists('beaver_marketplace_view')) {
    function beaver_marketplace_view(string $view, array $data = []): \Beaver\Http\Response
    {
        extract($data, EXTR_SKIP);
        $path = dirname(__DIR__) . '/app/views/' . $view . '.php';

        if (!is_file($path)) {
            return Response::text('View não encontrada: ' . $path, 404);
        }

        ob_start();
        require $path;
        return Response::html(ob_get_clean());
    }
}

// ── marketplace: página principal (com auth em destaque) ──
$router->get('/marketplace', function () {
    $products   = beaver_marketplace_products();
    $featured   = array_values(array_filter($products, fn($p) => !empty($p['badge'])));
    $categories = [
        ['slug' => 'plugins',  'label' => 'Plugins',     'icon' => '🔌', 'count' => 6],
        ['slug' => 'themes',   'label' => 'Temas',       'icon' => '🎨', 'count' => 2],
        ['slug' => 'services', 'label' => 'Serviços',    'icon' => '💼', 'count' => 2],
        ['slug' => 'courses',  'label' => 'Cursos',      'icon' => '🎓', 'count' => 1],
        ['slug' => 'tools',    'label' => 'Ferramentas', 'icon' => '🛠️', 'count' => 1],
    ];

    return beaver_marketplace_view('marketplace', [
        'title'      => 'marketplace · Beaver Framework',
        'version'    => \Beaver\Foundation\Application::VERSION,
        'year'       => date('Y'),
        'featured'   => $featured,
        'categories' => $categories,
        'stats'      => [
            'members'   => 4820,
            'products'  => count($products),
            'downloads' => array_sum(array_column($products, 'sales')),
        ],
    ]);
});

// ── marketplace: ver tudo / destaques ──
$router->get('/marketplace/all', function () {
    return beaver_marketplace_view('marketplace-all', [
        'title'    => 'Todos os produtos · marketplace',
        'version'  => \Beaver\Foundation\Application::VERSION,
        'year'     => date('Y'),
        'products' => beaver_marketplace_products(),
    ]);
});

$router->get('/marketplace/featured', function () {
    $featured = array_values(array_filter(
        beaver_marketplace_products(),
        fn($p) => !empty($p['badge'])
    ));
    return beaver_marketplace_view('marketplace-all', [
        'title'    => 'Em destaque · marketplace',
        'version'  => \Beaver\Foundation\Application::VERSION,
        'year'     => date('Y'),
        'products' => $featured,
    ]);
});

// ── marketplace: produto individual ──
$router->get('/marketplace/p/{slug}', function ($req, $slug) {
    $product = null;
    foreach (beaver_marketplace_products() as $p) {
        if ($p['slug'] === $slug) {
            $product = $p;
            break;
        }
    }

    if (!$product) {
        return Response::text('Produto não encontrado: ' . $slug, 404);
    }

    return beaver_marketplace_view('marketplace-product', [
        'title'   => $product['name'] . ' · marketplace Beaver',
        'version' => \Beaver\Foundation\Application::VERSION,
        'year'    => date('Y'),
        'product' => $product,
    ]);
});

// ── marketplace: landing para vendedores ──
$router->get('/marketplace/sellers', function () {
    return beaver_marketplace_view('marketplace-sellers', [
        'title'   => 'Vender no marketplace · Beaver',
        'version' => \Beaver\Foundation\Application::VERSION,
        'year'    => date('Y'),
    ]);
});

// ── marketplace: por categoria ──
$router->get('/marketplace/{category}', function ($req, $category) {
    $valid = ['plugins', 'themes', 'services', 'courses', 'tools'];

    if (!in_array($category, $valid, true)) {
        return Response::text('Categoria inválida', 404);
    }

    $products = array_values(array_filter(
        beaver_marketplace_products(),
        fn($p) => $p['category'] === $category
    ));

    return beaver_marketplace_view('marketplace-category', [
        'title'     => ucfirst($category) . ' · marketplace Beaver',
        'version'   => \Beaver\Foundation\Application::VERSION,
        'year'      => date('Y'),
        'category'  => $category,
        'products'  => $products,
    ]);
});

// ═══════════════════════════════════════════════════════════
//  AUTH — login, registo, logout, OAuth
// ═══════════════════════════════════════════════════════════

// ── Helpers de sessão (simples, baseados em $_SESSION) ──
if (!function_exists('beaver_auth_session_start')) {
    function beaver_auth_session_start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}

if (!function_exists('beaver_auth_user')) {
    function beaver_auth_user(): ?array
    {
        beaver_auth_session_start();
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('beaver_auth_login')) {
    function beaver_auth_login(array $user): void
    {
        beaver_auth_session_start();
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'    => $user['id']    ?? null,
            'name'  => $user['name']  ?? '',
            'email' => $user['email'] ?? '',
        ];
    }
}

if (!function_exists('beaver_auth_logout')) {
    function beaver_auth_logout(): void
    {
        beaver_auth_session_start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }
}

// ── POST /auth/login ──
$router->post('/auth/login', function ($req) {
    $email    = trim((string) $req->input('email', ''));
    $password = (string) $req->input('password', '');
    $remember = (bool)   $req->input('remember', false);

    $errors = [];
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email inválido.';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Palavra-passe demasiado curta.';
    }

    if ($errors) {
        return Response::json(['ok' => false, 'errors' => $errors], 422);
    }

    // TODO: substituir por lookup real na BD + password_verify()
    // Placeholder: aceita qualquer login válido em dev
    $user = [
        'id'    => 1,
        'name'  => 'Frank Onidesk',
        'email' => $email,
    ];

    beaver_auth_login($user);

    return Response::json([
        'ok'       => true,
        'redirect' => '/dashboard',
        'user'     => $user,
    ]);
});

// ── POST /auth/register ──
$router->post('/auth/register', function ($req) {
    $name     = trim((string) $req->input('name', ''));
    $email    = trim((string) $req->input('email', ''));
    $password = (string) $req->input('password', '');
    $terms    = (bool)   $req->input('terms', false);

    $errors = [];
    if (strlen($name) < 2) {
        $errors['name'] = 'Nome demasiado curto.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email inválido.';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'A palavra-passe precisa de pelo menos 8 caracteres.';
    } elseif (
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/\d/', $password)
    ) {
        $errors['password'] = 'Inclui maiúscula, minúscula e um número.';
    }
    if (!$terms) {
        $errors['terms'] = 'Tens de aceitar os termos.';
    }

    if ($errors) {
        return Response::json(['ok' => false, 'errors' => $errors], 422);
    }

    // TODO: verificar email duplicado na BD
    // TODO: User::create([...]) com password_hash($password, PASSWORD_ARGON2ID)

    $user = [
        'id'    => random_int(1000, 9999),
        'name'  => $name,
        'email' => $email,
    ];

    beaver_auth_login($user);

    return Response::json([
        'ok'       => true,
        'redirect' => '/marketplace',
        'user'     => $user,
        'message'  => 'Bem-vindo à barragem! 🦫',
    ]);
});

// ── POST /auth/logout ──
$router->post('/auth/logout', function () {
    beaver_auth_logout();
    return Response::json(['ok' => true, 'redirect' => '/marketplace']);
});

// ── OAuth (placeholders) ──
$router->get('/auth/github', function () {
    // TODO: redirect para https://github.com/login/oauth/authorize?client_id=...
    return Response::redirect('https://github.com/login/oauth/authorize');
});

$router->get('/auth/google', function () {
    // TODO: redirect para https://accounts.google.com/o/oauth2/v2/auth?...
    return Response::redirect('https://accounts.google.com/o/oauth2/v2/auth');
});

$router->get('/auth/apple', function () {
    // TODO: redirect para https://appleid.apple.com/auth/authorize?...
    return Response::redirect('https://appleid.apple.com/auth/authorize');
});

// ── GET /api/me — para o front saber se está logado ──
$router->get('/api/me', function () {
    $user = beaver_auth_user();
    return Response::json([
        'ok'       => true,
        'logged'   => $user !== null,
        'user'     => $user,
    ]);
});

// ── DEBUG temporário ──
error_log('[ROUTES-DUMP] total=' . count($router->routes()));
foreach ($router->routes() as $r) {
    error_log('[ROUTES-DUMP] ' . $r['method'] . ' ' . $r['path']);
}
