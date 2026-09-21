<?php

declare(strict_types=1);

namespace Beaver\Plugins\Skeleton\Tests;

use PHPUnit\Framework\TestCase;

final class PluginTest extends TestCase
{
    public function testManifestExisteEValido(): void
    {
        $path = __DIR__ . '/../plugin.json';
        $this->assertFileExists($path);

        $json = json_decode(file_get_contents($path), true);
        $this->assertIsArray($json);
        $this->assertSame('skeleton', $json['slug']);
        $this->assertSame('Beaver\\Plugins\\Skeleton', $json['namespace']);
    }

    public function testClassePrincipalExiste(): void
    {
        require_once __DIR__ . '/../src/SkeletonPlugin.php';
        $this->assertTrue(class_exists('Beaver\\Plugins\\Skeleton\\SkeletonPlugin'));
    }

    public function testAssetsExistem(): void
    {
        $this->assertFileExists(__DIR__ . '/../resources/ui/css/beaver-skeleton.css');
        $this->assertFileExists(__DIR__ . '/../resources/ui/js/beaver-skeleton.js');
    }
}
