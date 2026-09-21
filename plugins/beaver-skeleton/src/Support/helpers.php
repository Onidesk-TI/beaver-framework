<?php
declare(strict_types=1);

/**
 * Helpers do plugin Beaver Skeleton.
 *
 * Convenção: todas as funções globais começam por `beaver` em camelCase.
 * Ex.: beaverSkeleton(), beaverSkeletonConfig(), beaverSkeletonAsset().
 */

use Beaver\Plugins\Skeleton\SkeletonPlugin;

if (!function_exists('beaverSkeleton')) {
    /**
     * Devolve a instância do plugin Skeleton.
     */
    function beaverSkeleton(): SkeletonPlugin
    {
        return SkeletonPlugin::instance();
    }
}

if (!function_exists('beaverSkeletonConfig')) {
    /**
     * Lê uma chave da configuração do plugin.
     * Ex.: beaverSkeletonConfig('plugin.slug')
     */
    function beaverSkeletonConfig(?string $key = null, mixed $default = null): mixed
    {
        $config = require __DIR__ . '/../../config/config.php';

        if ($key === null) {
            return $config;
        }

        $value = $config;
        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        return $value;
    }
}

if (!function_exists('beaverSkeletonAsset')) {
    /**
     * Devolve o URL público de um asset do plugin.
     * Ex.: beaverSkeletonAsset('css/beaver-skeleton.css')
     *      -> /plugins/beaver-skeleton/css/beaver-skeleton.css
     */
    function beaverSkeletonAsset(string $path): string
    {
        $prefix = (string) beaverSkeletonConfig('assets.prefix', '/plugins/beaver-skeleton');
        return rtrim($prefix, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('beaverSkeletonPath')) {
    /**
     * Devolve o caminho absoluto dentro do plugin.
     * Ex.: beaverSkeletonPath('resources/views/index.php')
     */
    function beaverSkeletonPath(string $path = ''): string
    {
        $base = beaverSkeleton()->path ?? dirname(__DIR__, 2);
        return rtrim($base, '/') . ($path !== '' ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('beaverSkeletonVersion')) {
    /**
     * Devolve a versão do plugin, lida do plugin.json.
     */
    function beaverSkeletonVersion(): string
    {
        static $version = null;
        if ($version !== null) {
            return $version;
        }

        $manifest = __DIR__ . '/../../plugin.json';
        if (!is_file($manifest)) {
            return $version = '0.0.0';
        }

        $json = json_decode((string) file_get_contents($manifest), true);
        return $version = (string) ($json['version'] ?? '0.0.0');
    }
}
