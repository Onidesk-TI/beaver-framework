<?php

declare(strict_types=1);

/**
 * Acrescenta o card "Database" ao index.php do beaver-skeleton.
 * Aplica em: source + cópia.
 */

$files = [
    '/var/www/onidesk/beaver-skeleton/resources/views/index.php',
    '/var/www/onidesk/beaver-framework/plugins/beaver-skeleton/resources/views/index.php',
];

// Card novo (com a mesma estrutura dos existentes)
$card = <<<'HTML'

    <article class="sk-card">
      <span class="sk-icon">🗄️</span>
      <h2>Database</h2>
      <p>CRUD completo em <code>src/Models/</code> e <code>src/Services/</code>. Migrations em <code>database/migrations/</code>.</p>
    </article>

HTML;

foreach ($files as $file) {
    if (!is_file($file)) {
        echo "  ~ skip: $file\n";
        continue;
    }

    $src = file_get_contents($file);

    if (str_contains($src, '<h2>Database</h2>')) {
        echo "  ~ já tem card Database: " . basename(dirname($file)) . "\n";
        continue;
    }

    // Inserir DEPOIS do card "Rotas" (mantém a ordem temática)
    $needle = <<<'NEEDLE'
    <article class="sk-card">
      <span class="sk-icon">🛣️</span>
      <h2>Rotas</h2>
      <p>As rotas vivem em <code>routes/web.php</code> e são carregadas no <code>boot()</code>.</p>
    </article>

NEEDLE;

    if (!str_contains($src, $needle)) {
        // Fallback: inserir depois do card "Estrutura"
        $needle = <<<'NEEDLE'
    <article class="sk-card">
      <span class="sk-icon">📁</span>
      <h2>Estrutura</h2>
      <p>Edita <code>resources/views/index.php</code> para começar.</p>
    </article>

NEEDLE;
    }

    if (!str_contains($src, $needle)) {
        fwrite(STDERR, "  ✗ não encontrei ponto de inserção em $file\n");
        continue;
    }

    $src = str_replace($needle, $needle . $card, $src);
    file_put_contents($file, $src);
    echo "  + card Database adicionado: $file\n";
}

echo "\n✔ Pronto.\n";
