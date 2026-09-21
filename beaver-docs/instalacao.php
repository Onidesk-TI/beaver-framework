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
$pageTitle = 'Instalação';
$pageSubtitle = 'Requisitos e primeiros passos com o Beaver Framework';
$activeSlug = 'instalacao';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-download"></i>Requisitos</h2>
    <div class="beaver-card">
        <ul class="mb-0">
            <li><span class="badge badge-beaver">PHP 8.5+</span> com extensões <code class="inline-code">pdo</code>, <code class="inline-code">mbstring</code>, <code class="inline-code">ctype</code></li>
            <li>Composer 2.x</li>
            <li>Um SGBD suportado: MySQL, PostgreSQL, SQLite ou LocalDB</li>
            <li>FrankenPHP (opcional em produção, recomendado em desenvolvimento — ver secção dedicada)</li>
        </ul>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i>Criar o projeto</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">composer create-project beaver/framework meu-projeto
cd meu-projeto
php beaver serve</code></pre>
        <p class="mt-3 mb-0 text-muted small">
            O comando <code class="inline-code">beaver serve</code> arranca o servidor de desenvolvimento via FrankenPHP,
            com hot-reload ativado por omissão.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-database"></i>Configuração da base de dados</h2>
    <div class="beaver-card">
        <p class="mb-2">Edita o <code class="inline-code">.env</code> na raiz do projeto:</p>
        <pre><code class="language-ini">DB_DRIVER=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meu_projeto
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
APP_ENV=local
APP_DEBUG=true</code></pre>
        <p class="mt-3 mb-0 text-muted small">
            Para PostgreSQL, SQLite ou LocalDB basta trocar <code class="inline-code">DB_DRIVER</code> — o resto da configuração
            do ORM (models, migrations, queries) não muda uma linha de código.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-vial"></i>Confirmar a instalação</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver --version
php beaver migrate:status</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
