<?php
/**
 * Beaver Skeleton — config central
 *
 * Lê variáveis de ambiente com fallbacks seguros.
 * Uso:
 *   $cfg = require __DIR__ . '/config/config.php';
 *   $cfg['plugin']['slug'];
 *
 * Ou via helper (se existir):
 *   config('skeleton.plugin.slug')
 */

declare(strict_types=1);

/**
 * Lê uma variável de ambiente.
 * Tenta $_ENV, getenv() e $_SERVER, por esta ordem.
 */
function env(string $key, mixed $default = null): mixed
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }

    $value = getenv($key);
    if ($value !== false) {
        return $value;
    }

    if (array_key_exists($key, $_SERVER)) {
        return $_SERVER[$key];
    }

    return $default;
}

/**
 * Converte strings comuns em tipos nativos.
 * "true"/"false" -> bool | "123" -> int | "1.5" -> float
 */
function env_bool(string $key, bool $default = false): bool
{
    $v = env($key, $default);
    if (is_bool($v)) return $v;
    return filter_var($v, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
}

function env_int(string $key, int $default = 0): int
{
    return (int) env($key, $default);
}

return [

    // ---------------------------------------------------------
    //  Aplicação
    // ---------------------------------------------------------
    'app' => [
        'name'  => (string) env('APP_NAME', 'Beaver Skeleton'),
        'env'   => (string) env('APP_ENV', 'production'),
        'debug' => env_bool('APP_DEBUG', false),
        'url'   => (string) env('APP_URL', 'http://localhost:9000'),
    ],

    // ---------------------------------------------------------
    //  Plugin
    // ---------------------------------------------------------
    'plugin' => [
        'slug'    => (string) env('SKELETON_SLUG', 'skeleton'),
        'enabled' => env_bool('SKELETON_ENABLED', true),
        'version' => (string) env('SKELETON_VERSION', '0.1.0'),
    ],

    // ---------------------------------------------------------
    //  Rotas e assets
    // ---------------------------------------------------------
    'routes' => [
        'prefix' => (string) env('SKELETON_ROUTE_PREFIX', '/skeleton'),
    ],

    'assets' => [
        'prefix' => (string) env('SKELETON_ASSETS_PREFIX', '/plugins/beaver-skeleton'),
        'css'    => 'css',
        'js'     => 'js',
    ],

    // ---------------------------------------------------------
    //  Base de dados (opcional, se o plugin usar PDO)
    // ---------------------------------------------------------
    'database' => [
        'connection' => (string) env('DB_CONNECTION', 'sqlite'),
        'database'   => (string) env('DB_DATABASE', ':memory:'),
        'host'       => (string) env('DB_HOST', '127.0.0.1'),
        'port'       => env_int('DB_PORT', 3306),
        'username'   => (string) env('DB_USERNAME', ''),
        'password'   => (string) env('DB_PASSWORD', ''),
    ],

    // ---------------------------------------------------------
    //  Log
    // ---------------------------------------------------------
    'log' => [
        'channel' => (string) env('LOG_CHANNEL', 'stack'),
        'level'   => (string) env('LOG_LEVEL', 'debug'),
        'file'    => (string) env('LOG_FILE', '/tmp/beaver-skeleton.log'),
    ],

    // ---------------------------------------------------------
    //  Servidor de desenvolvimento
    // ---------------------------------------------------------
    'dev_server' => [
        'host' => (string) env('DEV_SERVER_HOST', 'localhost'),
        'port' => env_int('DEV_SERVER_PORT', 9000),
    ],

];
