<?php

/**
 * Rotas web da aplicação.
 *
 * Documentação do Router: ver /documentation ou /commands
 */

declare(strict_types=1);

use Beaver\Http\Router;
use Beaver\Http\Response;

// Instância do Router (sincronizada com o Application)
$router = Router::current();

// ── Homepage ──
$router->get('/', function () {
    return view('home/index', [
        'title' => beaver_version() . ' — ' . (getenv('APP_NAME') ?: 'Beaver'),
    ]);
});

// ── Health check ──
$router->get('/health', function () {
    return Response::json([
        'ok'      => true,
        'app'     => getenv('APP_NAME') ?: 'Beaver',
        'env'     => getenv('APP_ENV') ?: 'local',
        'time'    => date('c'),
        'version' => beaver_version(),
    ]);
});
