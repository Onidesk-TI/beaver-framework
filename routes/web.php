<?php

use Beaver\Http\Response;
use Beaver\Http\Router;

$router = Router::current();

// ── Landing ──
$router->get('/', function () {
    $view = dirname(__DIR__) . '/app/views/index.php';

    if (!is_file($view)) {
        return Response::html('<h1>Beaver Framework v' . beaver_version() . '</h1>');
    }

    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});

// ── Hello ──
$router->get('/hello', function () {
    return Response::html('<h1>HELLO — v' . beaver_version() . '</h1>');
});

// ── Ping ──
$router->get('/ping', function () {
    return Response::json(['ok' => true, 'time' => date('c'), 'version' => beaver_version()]);
});

// ── Preview de tema ──
$router->get('/theme-preview/{slug}', function ($req, $slug) {
    $slug = (string) $slug;

    if (!preg_match('/^[a-z][a-z0-9_-]*$/', $slug)) {
        return Response::text('Slug inválido', 400);
    }

    $mgr = app()->make(\Beaver\Sdk\Theme\ThemeManager::class);
    $dir = $mgr->path($slug);

    if ($dir === null) {
        return Response::text("Tema não encontrado: $slug", 404);
    }

    $viewFile = $dir . '/resources/views/index.php';
    if (!is_file($viewFile)) {
        return Response::text("View 'index' não encontrada no tema $slug", 404);
    }

    ob_start();
    require $viewFile;
    return Response::html(ob_get_clean());
});

// ── Helper: servir assets de temas ──
if (!function_exists('beaver_theme_serve_asset')) {
    function beaver_theme_serve_asset($mgr, string $slug, string $kind, string $file): Response
    {
        if (!preg_match('/^[a-z][a-z0-9_-]*$/', $slug)) {
            return Response::text('Forbidden', 403);
        }
        if (!in_array($kind, ['css', 'js'], true)) {
            return Response::text('Forbidden', 403);
        }
        if (!preg_match('/^[A-Za-z0-9_.-]+$/', $file)) {
            return Response::text('Forbidden', 403);
        }

        $base = $mgr->path($slug);
        if ($base === null) {
            return Response::text('Theme not found', 404);
        }

        $path = $base . '/resources/ui/' . $kind . '/' . $file;
        if (!is_file($path)) {
            return Response::text('Not found: ' . $kind . '/' . $file, 404);
        }

        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        $mime = match ($ext) {
            'css'   => 'text/css; charset=utf-8',
            'js'    => 'application/javascript; charset=utf-8',
            'svg'   => 'image/svg+xml',
            'png'   => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
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

// ── Assets: CSS de tema ──
$router->get('/themes/{slug}/css/{file}', function ($req, $slug, $file) {
    $mgr = app()->make(\Beaver\Sdk\Theme\ThemeManager::class);
    return beaver_theme_serve_asset($mgr, (string) $slug, 'css', (string) $file);
});

// ── Assets: JS de tema ──
$router->get('/themes/{slug}/js/{file}', function ($req, $slug, $file) {
    $mgr = app()->make(\Beaver\Sdk\Theme\ThemeManager::class);
    return beaver_theme_serve_asset($mgr, (string) $slug, 'js', (string) $file);
});

// ── DEBUG: o que o servidor envia ──
$router->get('/debug-request', function () {
    return Response::text(
        "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? '?') . "\n" .
        "PATH_INFO:   " . ($_SERVER['PATH_INFO'] ?? '?') . "\n" .
        "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? '?') . "\n" .
        "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? '?') . "\n"
    );
});
