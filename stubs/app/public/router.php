<?php

/**
 * Router para o servidor embutido do PHP (php -S).
 *
 * Serve ficheiros estáticos diretamente; tudo o resto vai
 * para public/index.php.
 */

declare(strict_types=1);

$uri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$file = __DIR__ . $uri;

// Se o pedido corresponde a um ficheiro real, deixa o PHP servi-lo
if ($uri !== '/' && is_file($file)) {
    return false;
}

// Caso contrário, passa para o entry-point da aplicação
require __DIR__ . '/index.php';
