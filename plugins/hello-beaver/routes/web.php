<?php
/**
 * Rotas do plugin HelloBeaver.
 *
 * @var \Beaver\Http\Router $router
 * @var \Beaver\Plugins\HelloBeaver\HelloBeaverPlugin $plugin
 */

use Beaver\Http\Response;

$router->get('/hello-beaver', function () use ($plugin) {
    return Response::json([
        'plugin'  => $plugin->name(),
        'slug'    => $plugin->slug(),
        'version' => $plugin->version(),
        'source'  => 'plugins/hello-beaver',
    ]);
});