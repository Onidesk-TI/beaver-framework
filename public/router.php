<?php
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    return false;   // deixa o PHP servir o estático
}

require __DIR__ . '/index.php';
