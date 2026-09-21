<?php

declare(strict_types=1);

namespace Beaver\Plugins\Skeleton;

use Beaver\Plugin\PluginBase;

class SkeletonPlugin extends PluginBase
{
    public function boot(): void
    {
        //uma forma de carregamos o .env para efeitos de teste
        if (class_exists(\Dotenv\Dotenv::class)) {
            \Dotenv\Dotenv::createImmutable($this->path)->safeLoad();
        }

        $this->loadRoutes();
        $this->loadViews();
        $this->loadTranslations();
    }
}
