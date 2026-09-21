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

$pageTitle    = 'Plugins';
$pageSubtitle = 'Sistema modular para estender o Beaver sem tocar no core.';
$activeSlug   = 'plugins';
require __DIR__ . '/partials/head.php';
?>

<section class="beaver-section">
  <h2><i class="fas fa-puzzle-piece"></i>O que são Plugins</h2>
  <p>
    O Beaver suporta um sistema modular de plugins que permite estender o
    framework sem tocar no core. Cada plugin vive em
    <code class="inline-code">app/plugins/{slug}/</code> e é descrito por
    um manifesto <code class="inline-code">plugin.json</code>.
  </p>
  <p>
    Um plugin pode registar rotas, views, hooks, migrações, comandos CLI,
    configurações e pontos de incorporação (páginas, secções, widgets e
    ações de registo) — tudo declarado no manifesto e validado pelo core
    antes de ser ativado.
  </p>
</section>

<section class="beaver-section">
  <h2><i class="fas fa-folder-tree"></i>Estrutura de um Plugin</h2>
  <div class="beaver-card">
<pre><code>app/plugins/sms/
├── plugin.json                 # Manifesto (obrigatório)
├── SmsPlugin.php               # Classe principal (bootstrap)
├── config/settings.php         # Definições da página de configuração
├── src/Controllers/            # Controllers do plugin
├── src/Services/               # Lógica de negócio
├── src/Providers/              # Integrações externas (ex: EZUY)
├── resources/views/            # Templates (Blade-like)
├── resources/assets/           # JS / CSS do plugin
├── routes/web.php              # Rotas registadas
├── database/migrations/        # Migrações próprias
└── storage/                    # Dados em runtime
    ├── logs/
    ├── cache/
    └── tmp/</code></pre>
  </div>
</section>

<section class="beaver-section">
  <h2><i class="fas fa-file-code"></i>Manifesto <code class="inline-code">plugin.json</code></h2>
  <div class="beaver-card">
<pre><code>{
  "name": "SMS",
  "slug": "sms",
  "version": "1.0.0",
  "namespace": "Beaver\\Plugins\\Sms",
  "main": "SmsPlugin.php",
  "beaver_version": "&gt;=1.0.0",
  "requires": {
    "php": "&gt;=8.1",
    "extensions": ["curl", "json"]
  },
  "hooks": ["record.render_actions", "page.render_widgets"],
  "admin_menu": { "label": "SMS", "icon": "fa-comment-sms" }
}</code></pre>
  </div>
</section>

<section class="beaver-section">
  <h2><i class="fas fa-shield-halved"></i>Permissões</h2>
  <p>Cada plugin declara explicitamente o que precisa. O admin vê estas
     permissões antes de ativar o plugin.</p>
  <div class="beaver-card">
    <ul class="mb-0">
      <li><strong>Filesystem</strong> — leitura / escrita</li>
      <li><strong>Network</strong> — hosts permitidos (ex: <code class="inline-code">api.hulksms.com:443</code>)</li>
      <li><strong>Database</strong> — tabelas de leitura / escrita / proibidas</li>
      <li><strong>Env</strong> — variáveis de ambiente visíveis</li>
      <li><strong>Hooks</strong> — lista branca de hooks</li>
      <li><strong>Routes</strong> — prefixo e middleware aplicado</li>
    </ul>
  </div>
</section>

<section class="beaver-section">
  <h2><i class="fas fa-download"></i>Instalação</h2>
  <p>No painel admin, em <strong>Plugins → Carregar</strong>, faz-se upload
     de um <code class="inline-code">.zip</code>. O Beaver:</p>
  <ol>
    <li>Valida o manifesto <code class="inline-code">plugin.json</code></li>
    <li>Verifica a assinatura digital</li>
    <li>Bloqueia <em>path traversal</em> e <em>zip-slip</em></li>
    <li>Extrai para <code class="inline-code">app/plugins/{slug}/</code></li>
    <li>Aplica permissões (root:www-data, 750 pastas, 640 ficheiros)</li>
    <li>Isola <code class="inline-code">storage/</code></li>
    <li>Regista o plugin na base de dados</li>
  </ol>
</section>

<section class="beaver-section">
  <h2><i class="fas fa-comment-sms"></i>Exemplo: Plugin SMS</h2>
  <p>Envia SMS via API HulkSMS (imaginário) com templates dinâmicos que suportam as variáveis:</p>
  <p>
    <span class="badge badge-beaver">{client}</span>
    <span class="badge badge-beaver">{user}</span>
    <span class="badge badge-beaver">{date}</span>
    <span class="badge badge-beaver">{time}</span>
    <span class="badge badge-beaver">{invoiceNo}</span>
  </p>
  <p>O botão <strong>Enviar SMS</strong> pode ser incorporado em páginas,
     secções, widgets e ações de registo.</p>
</section>

<div class="beaver-pager">
  <a href="dbscope.php"><i class="fas fa-arrow-left me-1"></i>DbScope</a>
  <a href="jobs.php">Jobs<i class="fas fa-arrow-right ms-1"></i></a>
</div>

        </div><!-- /.beaver-content -->
    </div><!-- /.beaver-layout -->

</body>
</html>