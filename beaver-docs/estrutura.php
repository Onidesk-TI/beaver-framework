<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */
$pageTitle = 'Estrutura de Pastas';
$pageSubtitle = 'Organização padrão de um projeto Beaver';
$activeSlug = 'estrutura';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-folder-tree"></i>Árvore de diretórios</h2>
    <div class="beaver-card">
        <pre><code class="language-text">meu-projeto/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Middleware/
│   ├── Commands/          # comandos CLI próprios
│   └── Providers/
├── config/
│   ├── database.php
│   ├── cache.php
│   └── security.php       # config do scanner FrankenPHP
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
├── routes/
│   ├── web.php
│   └── console.php        # registo de commands
├── storage/
│   ├── cache/
│   └── logs/
├── public/
│   └── index.php
├── .env
└── beaver                 # CLI executável</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-info-circle"></i>Notas rápidas</h2>
    <div class="beaver-card">
        <ul class="mb-0">
            <li><code class="inline-code">app/Commands/</code> — cada classe aqui fica disponível automaticamente via <code class="inline-code">php beaver</code> (ver secção Commands)</li>
            <li><code class="inline-code">config/security.php</code> — regras do scanner de segurança do FrankenPHP (padrões a ignorar, níveis de severidade, etc.)</li>
            <li><code class="inline-code">storage/cache/</code> — usado pelo driver <code class="inline-code">file</code> da camada de Cache</li>
        </ul>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
