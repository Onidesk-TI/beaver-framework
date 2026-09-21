<?php

/**
 * Rotas do plugin Paginator.
 * Assets servidos por symlink:
 *   public/plugins/paginator -> paginator/resources/ui
 *
 * @var \Beaver\Http\Router                        $router
 * @var \Beaver\Plugins\Paginator\PaginatorPlugin  $plugin
 */

use Beaver\Http\Response;

$router->get('/paginator/demo', function () use ($plugin) {
    $view = $plugin->path . '/resources/views/demo.php';
    if (!is_file($view)) {
        return Response::text('Demo não disponível', 404);
    }
    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});
