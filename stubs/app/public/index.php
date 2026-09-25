<?php

/**
 * Beaver Framework — Entry Point HTTP
 *
 * Este ficheiro é o único ponto de entrada público.
 * Toda a lógica de bootstrap está em bootstrap/app.php.
 */

declare(strict_types=1);

// 1) Servidor embutido do PHP: deixa passar ficheiros estáticos
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $file = __DIR__ . $path;
    if ($path !== '/' && is_file($file)) {
        return false;
    }
}

// 2) Marca o início (métricas de performance)
define('BEAVER_START', microtime(true));

// 3) Bootstrap: carrega .env, autoload, Application
try {
    /** @var \Beaver\Foundation\Application $app */
    $app = require __DIR__ . '/../bootstrap/app.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Erro no bootstrap:\n\n", $e->getMessage(), "\n";
    if (getenv('APP_DEBUG') === 'true') {
        echo "\n", $e->getTraceAsString(), "\n";
    }
    exit(1);
}

// 4) Arrancar: plugins + rotas + handle HTTP
$app->boot();
$app->handleHttp();
