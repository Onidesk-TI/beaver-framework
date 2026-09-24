<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    MIT <https://opensource.org/licenses/MIT>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

/**
 * Foundation helpers.
 *
 * Global functions available throughout the framework and the project.
 * Loaded once from Foundation\Application::__construct() after Env::load().
 */

if (!function_exists('env')) {
    /**
     * Read an environment variable, with a default and light type coercion.
     *
     *   env('EZ4U_KEY')                 → string|null
     *   env('APP_DEBUG', false)         → bool
     *   env('APP_NAME', 'Beaver')       → string
     *
     * "true"/"false"/"null"/"empty" (with or without parentheses)
     * are converted to their native PHP types.
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return match (strtolower($value)) {
            'true',  '(true)'  => true,
            'false', '(false)' => false,
            'null',  '(null)'  => null,
            'empty', '(empty)' => '',
            default            => $value,
        };
    }
}

if (!function_exists('base_path')) {
    /**
     * Absolute path to the project root (where the app is installed).
     * Optional $path is appended.
     */
    function base_path(string $path = ''): string
    {
        $base = \Beaver\Foundation\Application::getInstance()->basePath;
        return $path === '' ? $base : $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('storage_path')) {
    /**
     * Absolute path to the project's storage directory.
     */
    function storage_path(string $path = ''): string
    {
        $base = base_path('storage');
        return $path === '' ? $base : $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('config')) {
    /**
     * Read a config value using dot notation: config('app.timezone', 'UTC').
     */
    function config(?string $key = null, mixed $default = null): mixed
    {
        return \Beaver\Foundation\Application::getInstance()
            ->config($key, $default);
    }
}


if (!function_exists('beaver_version')) {
    function beaver_version(): string
    {
        static $v = null;
        if ($v !== null) return $v;

        $composer = dirname(__DIR__, 2) . '/composer.json';
        if (is_file($composer)) {
            $data = json_decode((string) file_get_contents($composer), true);
            if (!empty($data['version'])) {
                return $v = $data['version'];
            }
        }
        return $v = '0.0.0';
    }
}
