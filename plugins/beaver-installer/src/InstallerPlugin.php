<?php

declare(strict_types=1);

namespace Beaver\Plugins\BeaverInstaller;

use Beaver\Plugin\PluginBase;
use Beaver\Sdk\HooksCatalog;

class InstallerPlugin extends PluginBase
{
    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadRoutes();
        $this->loadMigrations();

        $this->hooks()->filter(HooksCatalog::ADMIN_MENU, function (array $items) {
            $items[] = [
                'label' => 'Plugins',
                'href'  => '/admin/plugins',
                'icon'  => '🔌',
                'order' => 5,
            ];
            return $items;
        });
    }
}
