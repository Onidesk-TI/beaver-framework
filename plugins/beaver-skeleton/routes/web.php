<?php

/**
 * Rotas do plugin Skeleton.
 *
 * @var \Beaver\Http\Router                     $router
 * @var \Beaver\Plugins\Skeleton\SkeletonPlugin $plugin
 */

use Beaver\Http\Response;

// ── Página standalone ──
$router->get('/skeleton', function () use ($plugin) {
    $view = $plugin->path . '/resources/views/index.php';
    if (!is_file($view)) {
        return Response::text('View não encontrada: ' . $view, 404);
    }
    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});

// ── Assets ──
if (!function_exists('skeleton_serve_asset')) {
    function skeleton_serve_asset($plugin, string $folder, string $file): Response
    {
        if (
            !preg_match('/^[A-Za-z0-9_-]+$/', $folder) ||
            !preg_match('/^[A-Za-z0-9_.-]+$/', $file)
        ) {
            return Response::text('Forbidden', 403);
        }

        $path = $plugin->path . '/resources/ui/' . $folder . '/' . $file;
        if (!is_file($path)) {
            return Response::text('Not found: ' . $path, 404);
        }

        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        $mime = match ($ext) {
            'css'   => 'text/css; charset=utf-8',
            'js'    => 'application/javascript; charset=utf-8',
            'svg'   => 'image/svg+xml',
            default => 'application/octet-stream',
        };

        return (new Response(file_get_contents($path)))
            ->withHeader('Content-Type', $mime);
    }
}

$router->get('/plugins/beaver-skeleton/css/{file}', function ($req, $file) use ($plugin) {
    return skeleton_serve_asset($plugin, 'css', (string) $file);
});

$router->get('/plugins/beaver-skeleton/js/{file}', function ($req, $file) use ($plugin) {
    return skeleton_serve_asset($plugin, 'js', (string) $file);
});
