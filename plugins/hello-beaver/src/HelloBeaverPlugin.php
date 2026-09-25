<?php

declare(strict_types=1);

namespace Beaver\Plugins\HelloBeaver;

use Beaver\Plugin\PluginBase;

class HelloBeaverPlugin extends PluginBase
{
    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadRoutes();
    }
}