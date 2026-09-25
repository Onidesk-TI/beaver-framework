<?php
/**
 * versions.php — Beaver Framework
 * Página de versões: framework, SDK, plugins, cursos e tags.
 */
declare(strict_types=1);

/* ──────── 1. Framework ──────── */
$rootPath     = dirname(__DIR__, 2);              // /var/www/onidesk/beaver-framework
$composerFile = $rootPath . '/composer.json';
$composer     = is_file($composerFile)
    ? json_decode((string) file_get_contents($composerFile), true)
    : [];
$fwVersion    = $composer['version'] ?? '0.0.0';
$fwPhp        = $composer['require']['php'] ?? '>=8.1';
$fwName       = $composer['name'] ?? 'beaver/framework';
$fwDesc       = $composer['description'] ?? 'Modern PHP Framework';

/* ──────── 2. SDK / Plugin API ──────── */
$sdkSchemaFile = $rootPath . '/sdk/schema/plugin.schema.json';
$sdkSchemaId   = null;
if (is_file($sdkSchemaFile)) {
    $s = json_decode((string) file_get_contents($sdkSchemaFile), true);
    $sdkSchemaId = $s['$id'] ?? null;
}
// Versão da API: mantida em constante — a view sdk.php também a mostra como "1.0.0"
$sdkApiVersion = '1.0.0';

/* ──────── 3. Plugins ──────── */
$plugins = [];
foreach (glob($rootPath . '/plugins/*/plugin.json') ?: [] as $file) {
    $j = json_decode((string) file_get_contents($file), true);
    if (!is_array($j) || empty($j['slug'])) continue;
    $plugins[] = [
        'slug'           => $j['slug'],
        'name'           => $j['name']           ?? $j['slug'],
        'version'        => $j['version']        ?? '0.0.0',
        'author'         => $j['author']         ?? '—',
        'description'    => $j['description']    ?? '',
        'beaver_version' => $j['beaver_version'] ?? '*',
        'enabled'        => (bool) ($j['enabled'] ?? false),
    ];
}
usort($plugins, fn ($a, $b) => strcmp($a['slug'], $b['slug']));

/* ──────── 4. Cursos (packs) ──────── */
$cursos = [];
foreach (glob($rootPath . '/plugins/*/curso.json') ?: [] as $file) {
    $j = json_decode((string) file_get_contents($file), true);
    if (!is_array($j) || empty($j['slug'])) continue;
    $cursos[] = [
        'slug'        => $j['slug'],
        'titulo'      => $j['titulo']      ?? $j['slug'],
        'descricao'   => $j['descricao']   ?? '',
        'preco'       => (float) ($j['preco'] ?? 0),
        'duracao_min' => (int)   ($j['duracao_min'] ?? 0),
        'ativo'       => (bool)  ($j['ativo'] ?? false),
    ];
}

/* ──────── 5. Git tags ──────── */
$gitTags = [];
$gitCmd  = 'cd ' . escapeshellarg($rootPath) . ' && git tag -l --sort=-v:refname 2>/dev/null';
$out     = @shell_exec($gitCmd);
if (is_string($out)) {
    foreach (preg_split('/\R/', trim($out)) as $t) {
        if ($t !== '') $gitTags[] = $t;
    }
}
$gitCurrent = trim((string) @shell_exec(
    'cd ' . escapeshellarg($rootPath) . ' && git describe --tags --always 2>/dev/null'
));

/* ──────── 6. Tema ativo ──────── */
$themeActive = null;
$themeFile   = $rootPath . '/storage/themes.json';
if (is_file($themeFile)) {
    $t = json_decode((string) file_get_contents($themeFile), true);
    $themeActive = $t['active'] ?? null;
}

/* ──────── 7. Data/hora ──────── */
$now = date('Y-m-d H:i');

/* helper para comparar versões simples */
$cmp = static function (string $a, string $b): string {
    // Só para colorir: se igual, "atual"; se a < b, "antiga"; se a > b, "nova"
    return version_compare($a, $b, '==') ? 'ok'
        : (version_compare($a, $b, '<') ? 'old' : 'new');
};
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Versões — Beaver Framework 🦫</title>
<meta name="description" content="Todas as versões do ecossistema Beaver: framework, SDK, plugins, cursos.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
  :root{
    --amber:#F5A623;--amber-2:#E07800;--amber-3:#FFC46B;--amber-4:#FFE0A6;--amber-deep:#8A4A00;
    --gray-50:#FAFAFA;--gray-100:#F4F5F7;--gray-200:#EAECEF;--gray-300:#D9DCE1;--gray-400:#B8BDC4;
    --gray-500:#8A9099;--gray-600:#5F656D;--gray-700:#3F444B;
    --bg:#F4F5F7;--card:#FFFFFF;
    --text:#2B2F36;--text-soft:#5F656D;--muted:#8A9099;
    --line:#E4E6EA;--line-strong:#D2D6DC;
    --code-bg:#FAF7F0;--code-text:#5A3A10;
    --ok:#2E9B5C;--warn:#E0A020;--err:#D0483A;--info:#3B7FC4;
  }
  html,body{height:100%}
  body{font-family:'Inter',system-ui,-apple-system,sans-serif;background:var(--bg);color:var(--text);line-height:1.65;-webkit-font-smoothing:antialiased;overflow-x:hidden;min-height:100vh;display:flex;flex-direction:column}
  body::before{content:"";position:fixed;inset:0;z-index:-2;background:radial-gradient(900px 560px at 10% -5%, rgba(245,166,35,.22), transparent 62%),radial-gradient(800px 500px at 92% 6%, rgba(255,196,107,.30), transparent 60%),radial-gradient(900px 560px at 50% 110%, rgba(224,120,0,.10), transparent 65%),linear-gradient(180deg, #FBFBFC 0%, var(--bg) 60%, #EEF0F3 100%)}
  body::after{content:"";position:fixed;inset:0;z-index:-1;pointer-events:none;background-image:linear-gradient(rgba(120,90,40,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(120,90,40,.05) 1px,transparent 1px);background-size:56px 56px;mask-image:radial-gradient(ellipse 100% 60% at 50% 0%,#000 25%,transparent 82%);-webkit-mask-image:radial-gradient(ellipse 100% 60% at 50% 0%,#000 25%,transparent 82%)}
  ::selection{background:rgba(245,166,35,.45);color:#3A2400}

  header{position:sticky;top:0;z-index:50;backdrop-filter:blur(20px) saturate(170%);-webkit-backdrop-filter:blur(20px) saturate(170%);background:rgba(250,250,252,.82);border-bottom:1px solid var(--line)}
  .nav-inner{max-width:1240px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;gap:20px;height:72px}
  .brand{display:flex;align-items:center;gap:11px;text-decoration:none;color:inherit;min-width:0}
  .brand-logo{width:42px;height:42px;border-radius:13px;flex:none;background:linear-gradient(150deg,var(--amber-4),var(--amber-3) 55%,var(--amber));border:1.5px solid rgba(138,74,0,.35);display:grid;place-items:center;box-shadow:0 8px 20px -10px rgba(224,120,0,.6), inset 0 1px 0 rgba(255,255,255,.7)}
  .brand-logo svg{width:28px;height:28px}
  .brand-text{display:flex;flex-direction:column}
  .brand-name{font-weight:800;font-size:1.2rem;letter-spacing:-.03em;line-height:1.1;color:#2B2F36}
  .brand-name .accent{color:var(--amber-2)}
  .brand-sub{font-size:.6rem;font-weight:700;letter-spacing:.22em;color:var(--amber-deep);text-transform:uppercase;line-height:1.2}
  .nav-links{display:flex;align-items:center;gap:6px;flex:none}
  .nav-link{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:10px;font-size:.86rem;font-weight:600;color:var(--gray-600);text-decoration:none;transition:all .2s;border:1px solid transparent}
  .nav-link:hover{color:var(--amber-deep);background:rgba(245,166,35,.10);border-color:rgba(224,120,0,.22)}
  .nav-link.active{color:var(--amber-deep);background:rgba(245,166,35,.14);border-color:rgba(224,120,0,.30)}
  .nav-link svg{width:15px;height:15px;flex:none;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
  .nav-cta{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:100px;font-size:.84rem;font-weight:700;color:#FFFFFF;text-decoration:none;background:linear-gradient(150deg,var(--amber-3),var(--amber) 50%,var(--amber-2));border:1px solid rgba(138,74,0,.35);box-shadow:0 8px 20px -10px rgba(224,120,0,.85), inset 0 1px 0 rgba(255,255,255,.55);text-shadow:0 1px 2px rgba(120,60,0,.30);transition:all .22s}
  .nav-cta:hover{transform:translateY(-1px)}
  .nav-cta svg{width:15px;height:15px;stroke:#fff;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}

  .hero{max-width:1240px;margin:0 auto;padding:44px 24px 8px;width:100%}
  .hero h1{font-size:clamp(1.6rem,3vw,2.2rem);letter-spacing:-.035em;font-weight:800;color:#2B2F36;margin-bottom:8px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
  .hero h1 .badge{font-family:'JetBrains Mono',monospace;font-size:.7rem;font-weight:700;padding:5px 10px;border-radius:100px;background:rgba(245,166,35,.18);color:var(--amber-deep);border:1px solid rgba(224,120,0,.28);letter-spacing:.02em;text-transform:uppercase}
  .hero p{color:var(--text-soft);max-width:720px;font-size:.98rem}
  .hero .meta{font-family:'JetBrains Mono',monospace;font-size:.75rem;color:var(--muted);margin-top:8px}

  .container{max-width:1240px;margin:0 auto;padding:24px;width:100%;flex:1}

  .section{margin-bottom:36px}
  .section-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
  .section-head h2{font-size:1.05rem;font-weight:800;letter-spacing:-.02em;color:#2B2F36}
  .section-head .hint{font-family:'JetBrains Mono',monospace;font-size:.72rem;color:var(--muted);font-weight:600}
  .section-head .line{flex:1;height:1px;background:var(--line)}

  .grid-2{display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:14px}

  .vcard{
    background:#fff;border:1px solid var(--line);border-radius:16px;
    padding:20px;box-shadow:0 10px 24px -18px rgba(60,60,70,.35);
    position:relative;overflow:hidden;
    transition:border-color .2s, box-shadow .2s;
  }
  .vcard:hover{border-color:rgba(224,120,0,.32);box-shadow:0 16px 34px -22px rgba(224,120,0,.55)}
  .vcard::before{content:"";position:absolute;inset:0;background:linear-gradient(160deg, rgba(245,166,35,.06), transparent 55%);pointer-events:none}
  .vcard .label{font-family:'JetBrains Mono',monospace;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--amber-deep);display:inline-flex;align-items:center;gap:6px}
  .vcard .version{font-size:2.4rem;font-weight:800;letter-spacing:-.04em;color:#2B2F36;line-height:1.1;margin:6px 0 4px}
  .vcard .version small{font-size:1rem;font-weight:600;color:var(--muted);letter-spacing:0}
  .vcard .sub{font-size:.84rem;color:var(--text-soft)}
  .vcard .foot{margin-top:14px;padding-top:12px;border-top:1px solid var(--line);font-family:'JetBrains Mono',monospace;font-size:.72rem;color:var(--muted);display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px}

  table.plugins{width:100%;background:#fff;border:1px solid var(--line);border-radius:14px;border-collapse:separate;border-spacing:0;overflow:hidden}
  table.plugins th{background:linear-gradient(180deg,#FBF9F4,#F6F3EC);font-family:'JetBrains Mono',monospace;font-size:.68rem;font-weight:700;color:var(--amber-deep);letter-spacing:.08em;text-transform:uppercase;text-align:left;padding:10px 14px;border-bottom:1px solid var(--line)}
  table.plugins td{padding:11px 14px;border-bottom:1px solid var(--line);font-size:.86rem;vertical-align:middle}
  table.plugins tr:last-child td{border-bottom:0}
  table.plugins tr:hover td{background:rgba(245,166,35,.035)}
  table.plugins .slug{font-family:'JetBrains Mono',monospace;font-size:.78rem;color:var(--amber-deep);font-weight:600}
  table.plugins .name{font-weight:600}
  table.plugins .desc{color:var(--text-soft);font-size:.8rem;max-width:420px}
  table.plugins .ver{font-family:'JetBrains Mono',monospace;font-size:.8rem;color:var(--gray-700);font-weight:600}
  table.plugins .badge{display:inline-flex;align-items:center;gap:5px;font-family:'JetBrains Mono',monospace;font-size:.68rem;font-weight:700;padding:3px 8px;border-radius:6px;letter-spacing:.04em}
  table.plugins .badge.on{background:rgba(46,155,92,.14);color:var(--ok);border:1px solid rgba(46,155,92,.25)}
  table.plugins .badge.off{background:rgba(208,72,58,.10);color:var(--err);border:1px solid rgba(208,72,58,.22)}

  .tags-list{display:flex;flex-direction:column;gap:6px;background:#fff;border:1px solid var(--line);border-radius:14px;padding:14px 18px}
  .tag-row{display:flex;align-items:center;gap:10px;font-family:'JetBrains Mono',monospace;font-size:.85rem;color:var(--gray-700)}
  .tag-row .dot{width:8px;height:8px;border-radius:50%;background:var(--amber-3);flex:none}
  .tag-row.current .dot{background:var(--ok);box-shadow:0 0 8px rgba(46,155,92,.6)}
  .tag-row .tag{font-weight:700;color:#2B2F36}
  .tag-row .mark{font-size:.7rem;color:var(--ok);font-weight:700;margin-left:6px}
  .tag-row .nada{color:var(--muted)}

  .chip{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:100px;background:rgba(245,166,35,.12);border:1px solid rgba(224,120,0,.24);color:var(--amber-deep);font-family:'JetBrains Mono',monospace;font-size:.75rem;font-weight:700}
  .chip .sw{width:10px;height:10px;border-radius:50%;background:var(--amber);box-shadow:0 0 8px rgba(245,166,35,.8)}

  footer{border-top:1px solid var(--line);background:rgba(250,250,252,.75);padding:22px 24px;text-align:center;font-size:.82rem;color:var(--text-soft);font-weight:500}
  footer .accent{color:var(--amber-2);font-weight:800}

  @media(max-width:720px){
    .nav-inner{padding:0 18px}
    .hero,.container{padding-left:18px;padding-right:18px}
    .nav-links .nav-link span{display:none}
    .nav-link{padding:9px}
    .vcard .version{font-size:1.9rem}
    table.plugins th, table.plugins td{padding:9px 10px;font-size:.78rem}
    table.plugins .desc{display:none}
  }
</style>
</head>
<body>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#FFE7BE"/><stop offset="48%" stop-color="#F5A623"/><stop offset="100%" stop-color="#E07800"/>
    </linearGradient>
    <symbol id="beaver" viewBox="0 0 64 64">
      <circle cx="13" cy="17.5" r="7.5" fill="url(#bvg)"/><circle cx="51" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <ellipse cx="32" cy="33" rx="23" ry="21" fill="url(#bvg)"/>
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#8A4A00" opacity=".28"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#2B1606"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#2B1606"/><circle cx="41.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="23.6" cy="25" r="1.2" fill="#FFFCF6"/><circle cx="42.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
    </symbol>
    <symbol id="ico-home" viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/></symbol>
    <symbol id="ico-book" viewBox="0 0 24 24"><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 0 4 22.5V4.5z"/><path d="M4 4.5A2.5 2.5 0 0 0 6.5 7H20"/></symbol>
    <symbol id="ico-terminal" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9l3 3-3 3"/><path d="M13 15h4"/></symbol>
    <symbol id="ico-tag" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></symbol>
    <symbol id="ico-gh" viewBox="0 0 24 24"><path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/></symbol>
  </defs>
</svg>

<?php
$active  = 'versions';
$version = $version ?? beaver_version();
require __DIR__ . '/partials/header-docs.php';
?>

<section class="hero">
  <h1>
    Versões
    <span class="badge">ecossistema · <?= date('Y') ?></span>
  </h1>
  <p>Todas as versões do Beaver num só lugar: framework, SDK, plugins oficiais, cursos, temas e tags git.</p>
  <div class="meta">atualizado em <?= htmlspecialchars($now) ?></div>
</section>

<main class="container">

  <!-- ─────────── Framework + SDK ─────────── -->
  <section class="section">
    <div class="section-head">
      <h2>Core</h2>
      <span class="hint">framework &amp; sdk</span>
      <span class="line"></span>
    </div>

    <div class="grid-2">
      <article class="vcard">
        <div class="label">⚙ Framework</div>
        <div class="version">v<?= htmlspecialchars($fwVersion) ?></div>
        <div class="sub"><?= htmlspecialchars($fwDesc) ?></div>
        <div class="foot">
          <span><?= htmlspecialchars($fwName) ?></span>
          <span>php <?= htmlspecialchars((string) $fwPhp) ?></span>
        </div>
      </article>

      <article class="vcard" id="sdk">
        <div class="label">📦 SDK · Plugin API</div>
        <div class="version">v<?= htmlspecialchars($sdkApiVersion) ?></div>
        <div class="sub">Contrato estável para plugins externos.</div>
        <div class="foot">
          <span><?= $sdkSchemaId ? htmlspecialchars((string) $sdkSchemaId) : 'schema local' ?></span>
          <span>estável</span>
        </div>
      </article>
    </div>
  </section>

  <!-- ─────────── Plugins ─────────── -->
  <section class="section">
    <div class="section-head">
      <h2>Plugins oficiais</h2>
      <span class="hint"><?= count($plugins) ?> encontrados</span>
      <span class="line"></span>
    </div>

    <?php if (empty($plugins)): ?>
      <div class="vcard"><div class="sub">Nenhum plugin encontrado em <code>plugins/*/plugin.json</code>.</div></div>
    <?php else: ?>
      <table class="plugins">
        <thead>
          <tr>
            <th>Slug</th>
            <th>Nome</th>
            <th>Versão</th>
            <th>Framework</th>
            <th>Autor</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($plugins as $p): ?>
          <tr>
            <td class="slug"><?= htmlspecialchars($p['slug']) ?></td>
            <td class="name"><?= htmlspecialchars($p['name']) ?></td>
            <td class="ver">v<?= htmlspecialchars($p['version']) ?></td>
            <td class="ver"><?= htmlspecialchars($p['beaver_version']) ?></td>
            <td><?= htmlspecialchars($p['author']) ?></td>
            <td>
              <?php if ($p['enabled']): ?>
                <span class="badge on">● ativo</span>
              <?php else: ?>
                <span class="badge off">● inativo</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>

  <!-- ─────────── Cursos ─────────── -->
  <?php if (!empty($cursos)): ?>
  <section class="section">
    <div class="section-head">
      <h2>Cursos disponíveis</h2>
      <span class="hint"><?= count($cursos) ?> pack(s)</span>
      <span class="line"></span>
    </div>

    <table class="plugins">
      <thead>
        <tr>
          <th>Slug</th>
          <th>Título</th>
          <th>Duração</th>
          <th>Preço</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cursos as $c): ?>
        <tr>
          <td class="slug"><?= htmlspecialchars($c['slug']) ?></td>
          <td class="name"><?= htmlspecialchars($c['titulo']) ?></td>
          <td class="ver"><?= (int) $c['duracao_min'] ?> min</td>
          <td class="ver">€<?= number_format($c['preco'], 2, ',', '.') ?></td>
          <td>
            <?php if ($c['ativo']): ?>
              <span class="badge on">● ativo</span>
            <?php else: ?>
              <span class="badge off">● inativo</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
  <?php endif; ?>

  <!-- ─────────── Git tags ─────────── -->
  <section class="section">
    <div class="section-head">
      <h2>Histórico de releases</h2>
      <span class="hint"><?= $gitCurrent ? htmlspecialchars($gitCurrent) : 'sem git' ?></span>
      <span class="line"></span>
    </div>

    <?php if (empty($gitTags)): ?>
      <div class="vcard"><div class="sub">Sem tags git registadas.</div></div>
    <?php else: ?>
      <div class="tags-list">
        <?php foreach ($gitTags as $i => $t): ?>
          <div class="tag-row<?= $i === 0 ? ' current' : '' ?>">
            <span class="dot"></span>
            <span class="tag"><?= htmlspecialchars($t) ?></span>
            <?php if ($i === 0): ?><span class="mark">última</span><?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- ─────────── Tema ─────────── -->
  <?php if ($themeActive): ?>
  <section class="section">
    <div class="section-head">
      <h2>Tema ativo</h2>
      <span class="hint">storage/themes.json</span>
      <span class="line"></span>
    </div>

    <div class="vcard">
      <div class="label">🎨 Tema</div>
      <div class="version" style="font-size:1.6rem"><?= htmlspecialchars($themeActive) ?></div>
      <div class="sub">O tema aplicado em todas as páginas do framework e plugins.</div>
    </div>
  </section>
  <?php endif; ?>

</main>

<footer>
  © <?= date('Y') ?> Beaver Framework · Feito com <span class="accent">🦫</span> em Portugal
</footer>

</body>
</html>
