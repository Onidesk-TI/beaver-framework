<?php

declare(strict_types=1);

/**
 * Corrige namespaces do beaver-skeleton e limpa composer.json.
 *
 * - Troca Beaver\Plugins\BeaverSkeleton → Beaver\Plugins\Skeleton
 *   em: Note.php, NoteService.php, routes/web.php (cópia + source)
 * - Adiciona "Beaver\\Plugins\\Skeleton\\" ao composer.json
 * - Remove entradas obsoletas (HelloBeaver, MeuPlugin)
 */

$framework = '/var/www/onidesk/beaver-framework';
$source    = '/var/www/onidesk/beaver-skeleton';

// ------------------------------------------------------------
// 1. Corrigir namespaces nos ficheiros (cópia + source)
// ------------------------------------------------------------
$targets = [
    "$framework/plugins/beaver-skeleton/src/Models/Note.php",
    "$framework/plugins/beaver-skeleton/src/Services/NoteService.php",
    "$framework/plugins/beaver-skeleton/routes/web.php",
    "$source/src/Models/Note.php",
    "$source/src/Services/NoteService.php",
    "$source/routes/web.php",
];

$oldNs = 'Beaver\\Plugins\\BeaverSkeleton';
$newNs = 'Beaver\\Plugins\\Skeleton';

foreach ($targets as $file) {
    if (!is_file($file)) {
        echo "  ~ skip (não existe): $file\n";
        continue;
    }

    $src = file_get_contents($file);
    if (!str_contains($src, $oldNs)) {
        echo "  ~ sem BeaverSkeleton: " . basename($file) . "\n";
        continue;
    }

    $src = str_replace($oldNs, $newNs, $src);
    file_put_contents($file, $src);
    echo "  + corrigido: " . basename($file) . "\n";
}

// ------------------------------------------------------------
// 2. composer.json — adicionar Skeleton, remover obsoletos
// ------------------------------------------------------------
$composerFile = "$framework/composer.json";
$j = json_decode(file_get_contents($composerFile), true, 512, JSON_THROW_ON_ERROR);

$psr4 = $j['autoload']['psr-4'] ?? [];

// Adicionar Skeleton
$skeletonKey = 'Beaver\\Plugins\\Skeleton\\';
$skeletonPath = 'plugins/beaver-skeleton/src/';

if (!isset($psr4[$skeletonKey])) {
    $psr4[$skeletonKey] = $skeletonPath;
    echo "  + adicionado: $skeletonKey\n";
} else {
    echo "  ~ já estava: $skeletonKey\n";
}

// Remover obsoletos
foreach (array_keys($psr4) as $key) {
    if (str_contains($key, 'HelloBeaver') || str_contains($key, 'MeuPlugin')) {
        unset($psr4[$key]);
        echo "  - removido: $key\n";
    }
}

// Ordenar alfabeticamente (exceto Beaver\ e App\ que ficam primeiro)
uksort($psr4, static function (string $a, string $b): int {
    $priority = ['Beaver\\' => 0, 'App\\' => 1, 'Beaver\\Sdk\\' => 2];
    $pa = $priority[$a] ?? 99;
    $pb = $priority[$b] ?? 99;
    return $pa !== $pb ? $pa <=> $pb : strcmp($a, $b);
});

$j['autoload']['psr-4'] = $psr4;

file_put_contents(
    $composerFile,
    json_encode($j, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n"
);

echo "\n✔ Namespaces e composer.json corrigidos.\n";
echo "\nPróximo passo: composer dump-autoload\n";
