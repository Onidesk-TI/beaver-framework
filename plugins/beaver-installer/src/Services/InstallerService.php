<?php

declare(strict_types=1);

/**
 * Beaver Installer — Installer service
 *
 * @package    Beaver Installer Plugin
 * @license    MIT <https://opensource.org/licenses/MIT>
 */

namespace Beaver\Plugins\BeaverInstaller\Services;

class InstallerService
{
    public function __construct(
        private ?StateService $state = null,
        private ?CatalogService $catalog = null,
        private ?string $pluginsDir = null,
        private ?string $composerBin = null,
    ) {
        $this->state     ??= new StateService();
        $this->catalog   ??= new CatalogService($this->state);
        $this->pluginsDir ??= dirname(__DIR__, 4) . '/plugins';
        $this->composerBin ??= trim((string) shell_exec('which composer 2>/dev/null')) ?: 'composer';
    }

    // ---------- ativar / desativar ----------

    public function enable(string $slug): array
    {
        if (!$this->exists($slug)) {
            return ['ok' => false, 'error' => "Plugin '$slug' não existe em disco"];
        }
        $this->state->enable($slug);
        return ['ok' => true, 'action' => 'enable', 'slug' => $slug];
    }

    public function disable(string $slug): array
    {
        if ($slug === 'beaver-installer') {
            return ['ok' => false, 'error' => 'O próprio installer não pode ser desativado'];
        }
        $this->state->disable($slug);
        return ['ok' => true, 'action' => 'disable', 'slug' => $slug];
    }

    public function toggle(string $slug): array
    {
        return $this->state->isEnabled($slug)
            ? $this->disable($slug)
            : $this->enable($slug);
    }

    // ---------- remover ----------

    public function remove(string $slug): array
    {
        if ($slug === 'beaver-installer') {
            return ['ok' => false, 'error' => 'O próprio installer não pode ser removido'];
        }
        if (!$this->exists($slug)) {
            return ['ok' => false, 'error' => "Plugin '$slug' não existe"];
        }

        $path = $this->pluginsDir . '/' . $slug;

        // Se for symlink, remove o link; se for pasta, remove recursivamente
        if (is_link($path)) {
            unlink($path);
        } else {
            $this->rmdir($path);
        }

        $this->state->markRemoved($slug);
        return ['ok' => true, 'action' => 'remove', 'slug' => $slug, 'path' => $path];
    }

    // ---------- instalar do marketplace ----------

    /**
     * Instala um repo do marketplace via git clone.
     *
     * @return array{ok:bool, slug?:string, path?:string, output?:string, error?:string}
     */
    public function installFromMarketplace(string $slug): array
    {
        $repo = null;
        foreach ($this->state->marketplaceRepos() as $r) {
            if (($r['slug'] ?? null) === $slug) {
                $repo = $r;
                break;
            }
        }
        if ($repo === null) {
            return ['ok' => false, 'error' => "Repo '$slug' não existe no marketplace"];
        }

        $url = $repo['url'] ?? '';
        if (!preg_match('#^https?://[^\s]+$#', $url)) {
            return ['ok' => false, 'error' => "URL inválido: $url"];
        }

        $target = $this->pluginsDir . '/' . $slug;
        if (file_exists($target)) {
            return ['ok' => false, 'error' => "Já existe: $target"];
        }

        $cmd = sprintf(
            'git clone --depth=1 %s %s 2>&1',
            escapeshellarg($url),
            escapeshellarg($target)
        );

        $output = (string) shell_exec($cmd);
        $ok = is_dir($target) && is_file($target . '/plugin.json');

        if (!$ok) {
            return ['ok' => false, 'error' => "Clone falhou: $output"];
        }

        // Limpeza: remover vendor se houver
        if (is_dir($target . '/vendor')) {
            $this->rmdir($target . '/vendor');
        }

        $this->state->markInstalled($slug, $url, $repo['version'] ?? '0.0.0');
        $this->state->enable($slug);

        return ['ok' => true, 'slug' => $slug, 'path' => $target, 'output' => $output];
    }

    /**
     * Regista um repo manualmente no marketplace e instala.
     */
    public function installFromUrl(string $url, ?string $name = null): array
    {
        if (!preg_match('#^https?://[^\s]+$#', $url)) {
            return ['ok' => false, 'error' => 'URL inválido'];
        }

        // Derivar slug do URL
        $slug = strtolower(basename(rtrim($url, '/')));
        $slug = preg_replace('#\.git$#', '', $slug);
        $slug = preg_replace('/[^a-z0-9_-]+/', '-', (string) $slug);
        $slug = trim((string) $slug, '-');

        if ($slug === '') {
            return ['ok' => false, 'error' => 'Não consegui derivar slug do URL'];
        }

        if (file_exists($this->pluginsDir . '/' . $slug)) {
            return ['ok' => false, 'error' => "Já existe: $slug"];
        }

        // Adicionar ao marketplace
        $this->state->addRepo([
            'slug'        => $slug,
            'name'        => $name ?? ucwords(str_replace('-', ' ', $slug)),
            'description' => 'Adicionado manualmente',
            'url'         => $url,
            'category'    => 'outros',
            'icon'        => '📦',
        ]);

        return $this->installFromMarketplace($slug);
    }

    // ---------- helpers ----------

    public function exists(string $slug): bool
    {
        $path = $this->pluginsDir . '/' . $slug;
        return is_dir($path) || is_link($path);
    }

    private function rmdir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($it as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($dir);
    }
}
