<?php

declare(strict_types=1);

/**
 * Beaver Installer — State service
 *
 * @package    Beaver Installer Plugin
 * @license    MIT <https://opensource.org/licenses/MIT>
 */

namespace Beaver\Plugins\BeaverInstaller\Services;

class StateService
{
    private string $pluginsFile;
    private string $marketplaceFile;

    public function __construct(?string $storagePath = null)
    {
        $base = $storagePath ?? dirname(__DIR__, 4) . '/storage';
        $this->pluginsFile     = rtrim($base, '/') . '/plugins.json';
        $this->marketplaceFile = rtrim($base, '/') . '/marketplace.json';
    }

    // ---------- plugins.json ----------

    public function state(): array
    {
        return $this->readJson($this->pluginsFile, [
            'version'   => 1,
            'enabled'   => [],
            'disabled'  => [],
            'installed' => [],
        ]);
    }

    public function saveState(array $state): void
    {
        $this->writeJson($this->pluginsFile, $state);
    }

    public function isEnabled(string $slug): bool
    {
        return in_array($slug, $this->state()['enabled'] ?? [], true);
    }

    public function isDisabled(string $slug): bool
    {
        return in_array($slug, $this->state()['disabled'] ?? [], true);
    }

    public function enable(string $slug): void
    {
        $s = $this->state();
        $s['enabled']  = array_values(array_unique(array_merge($s['enabled'] ?? [], [$slug])));
        $s['disabled'] = array_values(array_diff($s['disabled'] ?? [], [$slug]));
        $this->saveState($s);
    }

    public function disable(string $slug): void
    {
        $s = $this->state();
        $s['disabled'] = array_values(array_unique(array_merge($s['disabled'] ?? [], [$slug])));
        $s['enabled']  = array_values(array_diff($s['enabled'] ?? [], [$slug]));
        $this->saveState($s);
    }

    public function markInstalled(string $slug, string $source, string $version = '0.0.0'): void
    {
        $s = $this->state();
        $s['installed'][$slug] = [
            'source'       => $source,
            'version'      => $version,
            'installed_at' => time(),
        ];
        $this->saveState($s);
    }

    public function markRemoved(string $slug): void
    {
        $s = $this->state();
        unset($s['installed'][$slug]);
        $s['enabled']  = array_values(array_diff($s['enabled'] ?? [], [$slug]));
        $s['disabled'] = array_values(array_diff($s['disabled'] ?? [], [$slug]));
        $this->saveState($s);
    }

    public function installed(): array
    {
        return $this->state()['installed'] ?? [];
    }

    // ---------- marketplace.json ----------

    public function marketplace(): array
    {
        return $this->readJson($this->marketplaceFile, [
            'version'    => 1,
            'repos'      => [],
            'curated_by' => null,
        ]);
    }

    public function marketplaceRepos(): array
    {
        return $this->marketplace()['repos'] ?? [];
    }

    public function addRepo(array $repo): void
    {
        $data = $this->marketplace();
        $slug = $repo['slug'] ?? null;
        if (!$slug) {
            throw new \InvalidArgumentException('repo sem slug');
        }

        $repos = $data['repos'] ?? [];
        $replaced = false;
        foreach ($repos as $i => $r) {
            if (($r['slug'] ?? null) === $slug) {
                $repos[$i] = $repo;
                $replaced = true;
                break;
            }
        }
        if (!$replaced) {
            $repos[] = $repo;
        }

        $data['repos']      = $repos;
        $data['updated_at'] = date('Y-m-d');
        $this->writeJson($this->marketplaceFile, $data);
    }

    public function removeRepo(string $slug): void
    {
        $data = $this->marketplace();
        $data['repos'] = array_values(array_filter(
            $data['repos'] ?? [],
            fn (array $r) => ($r['slug'] ?? null) !== $slug
        ));
        $data['updated_at'] = date('Y-m-d');
        $this->writeJson($this->marketplaceFile, $data);
    }

    // ---------- helpers ----------

    private function readJson(string $path, array $default): array
    {
        if (!is_file($path)) {
            return $default;
        }
        $raw = file_get_contents($path);
        if ($raw === false) {
            return $default;
        }
        $data = json_decode($raw, true);
        return is_array($data) ? $data : $default;
    }

    private function writeJson(string $path, array $data): void
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n",
            LOCK_EX
        );
    }
}
