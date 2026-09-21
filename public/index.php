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

declare(strict_types=1);

if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if ($path !== '/' && is_file($file)) {
        return false;
    }
}

// --------------------------------------------------------------
// Beaver Framework — Entry Point HTTP
// --------------------------------------------------------------


define('BEAVER_START', microtime(true));

// Caminho base do projeto (uma pasta acima de public/)
$basePath = dirname(__DIR__);

// ============================================================
// 1. Carregar .env
// ============================================================
$envFile = $basePath . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $val] = explode('=', $line, 2);
        $key = trim($key);
        $val = trim($val);

        // Remove aspas
        if (strlen($val) >= 2) {
            $f = $val[0];
            $l = $val[strlen($val) - 1];
            if (($f === '"' && $l === '"') || ($f === "'" && $l === "'")) {
                $val = substr($val, 1, -1);
            }
        }

        putenv("$key=$val");
        $_ENV[$key]    = $val;
        $_SERVER[$key] = $val;
    }
}

// ============================================================
// 2. Autoload do Composer
// ============================================================
require $basePath . '/vendor/autoload.php';

// ============================================================
// 3. Helpers globais
// ============================================================
require_once $basePath . '/src/View/helpers.php';

use Beaver\Foundation\Application;

// ============================================================
// 4. Arrancar
// ============================================================
$app = new Application($basePath);
$app->boot();
$app->handleHttp();
