<?php

declare(strict_types=1);

/**
 * Beaver Installer — Catalog service
 *
 * Junta 3 fontes:
 *   1. PluginManager  → plugins descobertos em disco
 *   2. plugins.json   → enabled/disabled/installed
 *   3. marketplace.json → repositórios disponíveis para instalar
 *
 * @package    Beaver Installer Plugin
 * @license    MIT <https://opensource.org/licenses/MIT>
 */

namespace Beaver\Plugins\BeaverInstaller\Services;

use Beaver\Foundation\Application;
use Beaver\Plugin\PluginManager;

class CatalogService
{
    public function __construct(
        private ?StateService $state = null,
        private ?PluginManager $manager = null,
    ) {
        $this->state   ??= new StateService();
        $this->manager ??= Application::getInstance()->make(PluginManager::class);
    }

    /**
     * Lista de plugins INSTALADOS (em disco), com estado.
     *
     * @return array<int,array{
     *   slug:string, name:string, version:string,
     *   source:string, path:string,
     *   enabled:bool, is_native:bool, has_screenshot:bool
     * }>
     */
    public function installed(): array
    {
        $this->manager->discover();

        $out = [];
        foreach ($this->manager->manifests() as $m) {
            $slug = $m['slug'] ?? '';
            if ($slug === '') {
                continue;
            }

            $path   = $m['path'] ?? '';
            $source = $m['source'] ?? 'unknown';

            // Estado: por defeito, plugins "internal" estão enabled
            $isNative = in_array($source, ['internal', 'dev'], true) && $slug !== 'beaver-installer';
            $enabled  = $this->state->isEnabled($slug)
                     || ($isNative && !$this->state->isDisabled($slug));

            // Screenshot
            $shotsPath = $path . '/resources/ui/screenshots';
            $hasShot   = is_dir($shotsPath) && count(glob($shotsPath . '/*.{png,jpg,webp}', GLOB_BRACE) ?: []) > 0;

            $out[] = [
                'slug'           => $slug,
                'name'           => $m['name'] ?? $slug,
                'version'        => $m['version'] ?? '0.0.0',
                'source'         => $source,
                'path'           => $path,
                'enabled'        => $enabled,
                'is_native'      => $isNative,
                'has_screenshot' => $hasShot,
                'is_self'        => $slug === 'beaver-installer',
            ];
        }

        usort($out, fn ($a, $b) => strcmp($a['slug'], $b['slug']));
        return $out;
    }

    /**
     * Repositórios do marketplace que AINDA NÃO estão instalados.
     */
    public function available(): array
    {
        $installedSlugs = array_column($this->installed(), 'slug');

        $out = [];
        foreach ($this->state->marketplaceRepos() as $r) {
            $slug = $r['slug'] ?? '';
            if ($slug === '' || in_array($slug, $installedSlugs, true)) {
                continue;
            }
            $out[] = [
                'slug'        => $slug,
                'name'        => $r['name'] ?? $slug,
                'description' => $r['description'] ?? '',
                'url'         => $r['url'] ?? '',
                'category'    => $r['category'] ?? 'outros',
                'icon'        => $r['icon'] ?? '📦',
            ];
        }
        return $out;
    }

    /**
     * Repositórios do marketplace (todos, mesmo os já instalados).
     */
    public function marketplace(): array
    {
        return $this->state->marketplaceRepos();
    }

    public function stats(): array
    {
        $installed = $this->installed();
        $enabled   = 0;
        $disabled  = 0;
        $native    = 0;
        foreach ($installed as $p) {
            $p['enabled'] ? $enabled++ : $disabled++;
            if ($p['is_native']) {
                $native++;
            }
        }

        return [
            'installed_total'  => count($installed),
            'enabled'          => $enabled,
            'disabled'         => $disabled,
            'native'           => $native,
            'available'        => count($this->available()),
        ];
    }
}
