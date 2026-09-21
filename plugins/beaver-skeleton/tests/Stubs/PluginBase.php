<?php

declare(strict_types=1);

namespace Beaver\Plugin;

/**
 * Stub da PluginBase real, usada APENAS nos testes.
 * Fora do framework, esta classe não existe.
 */
abstract class PluginBase
{
    public string $path = '';

    public function loadRoutes(): void
    {
    }
    public function loadViews(): void
    {
    }
    public function loadTranslations(): void
    {
    }
}
