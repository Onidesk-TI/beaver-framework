<?php
/**
 * Beaver SDK — página oficial
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    MIT <https://opensource.org/licenses/MIT>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */

$title   = 'Beaver SDK · Plugin API v1.0.0';
$version = beaver_version();
$year    = date('Y');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?></title>
<meta name="description" content="Beaver SDK — contrato oficial para desenvolvimento de plugins.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/resources/ui/css/beaver.css">
</head>
<body>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#FFD79A"/>
      <stop offset="48%" stop-color="#FF9A3C"/>
      <stop offset="100%" stop-color="#FF6B35"/>
    </linearGradient>
    <symbol id="beaver" viewBox="0 0 64 64">
      <circle cx="13" cy="17.5" r="7.5" fill="url(#bvg)" opacity=".72"/>
      <circle cx="51" cy="17.5" r="7.5" fill="url(#bvg)" opacity=".72"/>
      <ellipse cx="32" cy="33" rx="23" ry="21" fill="url(#bvg)"/>
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#0A0E14" opacity=".18"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#1A1208"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#1A1208"/>
      <circle cx="41.5" cy="26" r="3.4" fill="#1A1208"/>
      <circle cx="23.6" cy="25" r="1.1" fill="#FFF6E8" opacity=".9"/>
      <circle cx="42.6" cy="25" r="1.1" fill="#FFF6E8" opacity=".9"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFF6E8"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFF6E8"/>
    </symbol>
    <symbol id="ico-gh" viewBox="0 0 24 24">
      <path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/>
    </symbol>
    <symbol id="ico-repo" viewBox="0 0 24 24">
      <path d="M4 4a2 2 0 0 1 2-2h11a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 0-1 1 1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-1h1.5a.5.5 0 0 1 .5.5V21a2 2 0 0 1-2 2H6a3 3 0 0 1-3-3V4zm3 1v9l2.5-1.6L12 14V5H7z"/>
    </symbol>
    <symbol id="ico-key" viewBox="0 0 24 24">
      <path d="M14.5 2a5.5 5.5 0 0 0-5.4 6.5L2 15.6V19h3.4l1-1v-1.4H8v-1.4h1.4v-1.4l1.1-1.1A5.5 5.5 0 1 0 14.5 2zm1.7 4.7a1.4 1.4 0 1 1 0-2.8 1.4 1.4 0 0 1 0 2.8z"/>
    </symbol>
    <symbol id="ico-sql" viewBox="0 0 24 24">
      <ellipse cx="12" cy="6" rx="8" ry="3"/>
      <path d="M4 6v6c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/>
      <path d="M4 12v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>
    </symbol>
  </defs>
</svg>

<?php
$navContext = 'default';
$navExtra   = [['label' => 'SDK', 'href' => '/sdk', 'icon' => '🧩']];
require __DIR__ . '/partials/header.php';
?>

<main>
  <section class="card">
    <div class="card-content">
      <div class="pill">
        <span class="pulse-dot"></span>
        Plugin API v1.0.0 — estável
      </div>

      <svg class="beaver" aria-hidden="true"><use href="#beaver"/></svg>

      <h1>
        Escreve plugins<br>
        <span class="grad">sem quebrar regras</span><br>
        <span class="stroke">com um SDK sólido</span>
      </h1>

      <p class="lead">
        Manifesto tipado, validação automática, permissões em modo audit
        e harness de testes. Tudo o que precisas para construir plugins
        que convivem bem com o Beaver — e com outros.
      </p>

      <div class="cta-row">
        <a href="#manifest" class="btn btn-primary">
          Ver referência
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
        <a href="https://github.com/Onidesk-TI/beaver-framework" target="_blank" rel="noopener" class="btn btn-ghost">
          <svg viewBox="0 0 24 24" fill="currentColor"><use href="#ico-gh"/></svg>
          Ver no GitHub
        </a>
      </div>

      <div class="divider">O que o SDK garante</div>

      <p class="home-note">
        <span class="icon">🧩</span>
        Estável desde v1.0.0 — muda só com nova versão de API.
      </p>
    </div>

    <div class="right-col">
      <aside class="terminal" aria-hidden="true">
        <div class="terminal-bar">
          <div class="terminal-dots"><i></i><i></i><i></i></div>
          <span class="terminal-title">beaver@barragem — ~/sdk</span>
        </div>
        <div class="terminal-body">
          <div><span class="accent">$</span> php beaver plugin:make hello-beaver</div>
          <div class="dim">› Plugin criado: plugins/hello-beaver</div>
          <div class="dim">✓ Manifesto válido pelo Beaver SDK</div>
          <div class="dim">✓ Autoload registado</div>
          <div>&nbsp;</div>
          <div><span class="accent">$</span> php beaver plugin:validate</div>
          <div class="dim">✓ beaver-nav  [internal]</div>
          <div class="dim">✓ paginator   [internal]</div>
          <div class="dim">✓ sms         [dev]</div>
          <div>&nbsp;</div>
          <div><span class="accent">$</span> php beaver plugin:audit</div>
          <div class="dim">Mode: audit — 0 eventos</div>
        </div>
      </aside>
    </div>
  </section>

  <section class="card" id="manifest" style="margin-top:24px">
    <div class="card-content">
      <div class="pill"><span class="pulse-dot"></span>Referência</div>
      <h2 style="font-size:1.6rem;margin:.4em 0">plugin.json</h2>
      <p class="lead">Manifesto obrigatório de cada plugin. Validado por <code>ManifestValidator</code>.</p>
      <pre style="background:#0A0E14;color:#F5EBD8;padding:16px;border-radius:10px;overflow:auto;font-family:'JetBrains Mono',monospace;font-size:.85rem;line-height:1.5">{
  "name":           "Sms Gateway",
  "slug":           "sms-gateway",
  "version":        "1.0.0",
  "namespace":      "Beaver\\\\Plugins\\\\SmsGateway",
  "main":           "src/SmsGatewayPlugin.php",
  "beaver_version": "&gt;=0.1.0",
  "api_version":    "1.0.0",
  "permissions":    ["db.read", "hooks.listen"]
}</pre>
    </div>
  </section>

  <section class="card" id="cli" style="margin-top:24px">
    <div class="card-content">
      <div class="pill"><span class="pulse-dot"></span>CLI</div>
      <h2 style="font-size:1.6rem;margin:.4em 0">Comandos disponíveis</h2>
      <p class="lead">Todos aceitam <code>--json</code> para output programático.</p>
      <ul style="line-height:2;padding-left:1.2em">
        <li><code>php beaver plugin:list</code> — lista todos os plugins</li>
        <li><code>php beaver plugin:validate [slug]</code> — valida manifestos</li>
        <li><code>php beaver plugin:info &lt;slug&gt;</code> — detalhes de um plugin</li>
        <li><code>php beaver plugin:make &lt;nome&gt; [--dest=PATH]</code> — cria plugin novo</li>
        <li><code>php beaver plugin:audit [--clear]</code> — eventos de permissão</li>
      </ul>
    </div>
  </section>

  <section class="card" id="permissoes" style="margin-top:24px">
    <div class="card-content">
      <div class="pill"><span class="pulse-dot"></span>Permissões</div>
      <h2 style="font-size:1.6rem;margin:.4em 0">Modo audit / enforce</h2>
      <p class="lead">Configura em <code>config/app.php</code> ou via <code>BEAVER_PERMISSIONS_MODE</code>.</p>
      <ul style="line-height:2;padding-left:1.2em">
        <li><code>off</code> — não verifica nada</li>
        <li><code>audit</code> — registra no log, não bloqueia <em>(default)</em></li>
        <li><code>enforce</code> — bloqueia com <code>PermissionDeniedException</code></li>
      </ul>
    </div>
  </section>

  <section class="card" id="testing" style="margin-top:24px">
    <div class="card-content">
      <div class="pill"><span class="pulse-dot"></span>Testing</div>
      <h2 style="font-size:1.6rem;margin:.4em 0">Harness incluído</h2>
      <p class="lead">Testa plugins sem bootar o framework.</p>
      <pre style="background:#0A0E14;color:#F5EBD8;padding:16px;border-radius:10px;overflow:auto;font-family:'JetBrains Mono',monospace;font-size:.85rem;line-height:1.5">$t = PluginTester::for(MyPlugin::class, __DIR__ . '/..');
$t-&gt;validateManifest();
$t-&gt;boot();
$this-&gt;assertTrue($t-&gt;hooks-&gt;wasEmitted('plugin.booted'));</pre>
    </div>
  </section>
</main>

<footer>
  © <?= htmlspecialchars((string) $year) ?> Beaver Framework · Feito com <span class="accent">🦫</span> em Portugal
</footer>

<script src="/resources/ui/js/beaver.js"></script>
</body>
</html>