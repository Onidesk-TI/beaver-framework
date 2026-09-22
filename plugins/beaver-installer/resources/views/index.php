<?php
/**
 * Beaver Installer — view de gestão de plugins
 *
 * @var array $stats      { installed_total, enabled, disabled, native, available }
 * @var array $installed  [{ slug, name, version, source, enabled, is_native, has_screenshot, is_self }, ...]
 * @var array $available  [{ slug, name, description, url, category, icon }, ...]
 * @var array $user       (via view globals)
 */
$u = $user ?? null;
$name  = $u->name ?? 'Convidado';
$email = $u->email ?? '';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Plugins · Beaver Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="/resources/ui/css/beaver.css">
<style>
  *{box-sizing:border-box}
  body{margin:0;font-family:Inter,sans-serif;background:#fdf8ef;color:#2E1A10}
  .sidebar{position:fixed;left:0;top:0;bottom:0;width:240px;background:#fff8ec;border-right:1px solid #eadfc7;display:flex;flex-direction:column;z-index:50}
  .sidebar-brand{display:flex;align-items:center;gap:.55rem;padding:1.1rem 1.2rem;border-bottom:1px solid #eadfc7;font-weight:700;font-size:1rem}
  .sidebar-nav{flex:1;overflow-y:auto;padding:.8rem .6rem;display:flex;flex-direction:column;gap:.1rem}
  .sidebar-label{font-size:.68rem;text-transform:uppercase;letter-spacing:.08em;color:#a08f7a;padding:.9rem .8rem .35rem;font-weight:600}
  .sidebar-link{display:flex;align-items:center;gap:.7rem;padding:.55rem .8rem;border-radius:8px;color:#6b5544;text-decoration:none;font-size:.88rem}
  .sidebar-link i{width:18px;text-align:center;color:#a08f7a}
  .sidebar-link:hover{background:#f5ead0;color:#2E1A10}
  .sidebar-link:hover i{color:#c25a1f}
  .sidebar-link.is-active{background:linear-gradient(140deg,#FF9A3C,#FF6B35);color:#fff;font-weight:600}
  .sidebar-link.is-active i{color:#fff}
  .sidebar-footer{padding:.6rem;border-top:1px solid #eadfc7}
  .app-header{position:fixed;top:0;left:240px;right:0;height:56px;background:#fff8ec;border-bottom:1px solid #eadfc7;z-index:40}
  .app-header-inner{display:flex;justify-content:space-between;align-items:center;height:100%;padding:0 1.5rem;max-width:1100px;margin:0 auto}
  .app-header-nav{display:flex;gap:1rem;align-items:center}
  .app-header-link{text-decoration:none;color:#6b5544;font-size:.88rem}
  .app-header-link:hover{color:#c25a1f}
  .user-menu{position:relative}
  .user-btn{display:flex;align-items:center;justify-content:center;width:38px;height:38px;background:#fff;border:1px solid #eadfc7;border-radius:50%;cursor:pointer;color:#c25a1f}
  .user-icon{width:20px;height:20px}
  .user-dropdown{position:absolute;top:calc(100% + 8px);right:0;min-width:220px;background:#fff;border:1px solid #eadfc7;border-radius:10px;box-shadow:0 8px 24px rgba(74,44,29,.14);padding:.8rem;display:none;z-index:60}
  .user-dropdown.open{display:block}
  .user-info{display:flex;flex-direction:column;gap:.15rem;padding-bottom:.6rem;margin-bottom:.6rem;border-bottom:1px solid #eee4cf}
  .user-info small{font-size:.75rem;color:#8a7560;font-family:'JetBrains Mono',monospace;word-break:break-all}
  .user-logout{width:100%;padding:.55rem;background:#fff;border:1px solid #e2d4b8;border-radius:6px;cursor:pointer;font-family:inherit;font-size:.85rem;color:#991b1b}
  .user-logout:hover{background:#fef2f2}
  body{margin-left:240px;padding-top:56px}
  main{max-width:1100px;margin:0 auto;padding:2rem 1.5rem}

  .stats{display:flex;gap:1rem;flex-wrap:wrap;margin:1rem 0 2rem}
  .stat{background:#fff;border:1px solid #eadfc7;border-radius:10px;padding:.9rem 1.3rem;min-width:110px;text-align:center}
  .stat b{display:block;font-size:1.6rem;color:#c25a1f}
  .stat small{color:#8a7560;font-size:.72rem;text-transform:uppercase;letter-spacing:.5px}

  h2.section{margin:2rem 0 .8rem;font-size:1.15rem;display:flex;align-items:center;gap:.6rem}
  h2.section .count{background:#f5ead0;color:#8a7560;font-size:.75rem;padding:.15rem .55rem;border-radius:99px;font-weight:600}

  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem}
  .card{background:#fff;border:1px solid #eee4cf;border-radius:12px;padding:1.1rem;box-shadow:0 2px 6px rgba(74,44,29,.05);display:flex;flex-direction:column;gap:.6rem}
  .card.off{opacity:.62;background:#fafafa}
  .card-head{display:flex;justify-content:space-between;align-items:flex-start;gap:.6rem}
  .card-title{font-weight:700;font-size:1rem;margin:0;display:flex;align-items:center;gap:.4rem}
  .card-slug{font-family:'JetBrains Mono',monospace;font-size:.75rem;color:#a08f7a;margin:.1rem 0}
  .card-meta{display:flex;gap:.6rem;font-size:.75rem;color:#8a7560;flex-wrap:wrap}
  .badge{display:inline-flex;align-items:center;gap:.25rem;padding:.15rem .5rem;border-radius:99px;font-size:.7rem;font-weight:600}
  .badge-on{background:#dcfce7;color:#166534}
  .badge-off{background:#f3f4f6;color:#6b7280}
  .badge-native{background:#dbeafe;color:#1e40af}
  .badge-external{background:#fef3c7;color:#92400e}
  .card-actions{display:flex;gap:.4rem;margin-top:auto;flex-wrap:wrap}
  .btn{padding:.45rem .85rem;border-radius:6px;border:1px solid #e2d4b8;background:#fdf8ef;color:#2E1A10;font-family:inherit;font-size:.82rem;cursor:pointer;display:inline-flex;align-items:center;gap:.35rem;text-decoration:none}
  .btn:hover{background:#f5ead0}
  .btn-primary{background:linear-gradient(140deg,#FF9A3C,#FF6B35);color:#fff;border:0}
  .btn-primary:hover{opacity:.92}
  .btn-danger{color:#991b1b;border-color:#fecaca}
  .btn-danger:hover{background:#fef2f2}
  .btn:disabled{opacity:.5;cursor:not-allowed}

  .install-box{background:#fff;border:1px dashed #d9cbb2;border-radius:12px;padding:1.2rem;margin-top:1rem}
  .install-row{display:flex;gap:.5rem;flex-wrap:wrap}
  .install-row input{flex:1;min-width:200px;padding:.65rem .85rem;border:1px solid #d9cbb2;border-radius:8px;font-family:inherit;background:#fdf8ef;font-size:.9rem}

  .empty{color:#a08f7a;text-align:center;padding:2rem;font-size:.9rem}
  .toast{position:fixed;bottom:1.5rem;right:1.5rem;padding:.9rem 1.2rem;border-radius:10px;background:#2E1A10;color:#fff;font-size:.9rem;box-shadow:0 8px 24px rgba(0,0,0,.2);display:none;z-index:100}
  .toast.show{display:block}
  .toast.error{background:#991b1b}
</style>
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
  </defs>
</svg>

<aside class="sidebar">
  <div class="sidebar-brand"><svg style="width:28px;height:28px"><use href="#beaver"/></svg><span>Beaver<span style="color:#c25a1f">.</span> Admin</span></div>
  <nav class="sidebar-nav">
    <span class="sidebar-label">Principal</span>
    <a href="/admin" class="sidebar-link"><i class="fas fa-gauge"></i> Dashboard</a>
    <a href="/admin/plugins" class="sidebar-link is-active"><i class="fas fa-plug"></i> Plugins</a>
    <a href="/admin/notes" class="sidebar-link"><i class="fas fa-note-sticky"></i> Notas</a>
    <a href="/admin/users" class="sidebar-link"><i class="fas fa-users"></i> Utilizadores</a>
    <span class="sidebar-label">Vendas</span>
    <a href="/admin/orders" class="sidebar-link"><i class="fas fa-shopping-cart"></i> Encomendas</a>
    <a href="/admin/products" class="sidebar-link"><i class="fas fa-box"></i> Produtos</a>
    <span class="sidebar-label">Sistema</span>
    <a href="/admin/reports" class="sidebar-link"><i class="fas fa-chart-line"></i> Relatórios</a>
    <a href="/admin/logs" class="sidebar-link"><i class="fas fa-list"></i> Logs</a>
    <a href="/admin/settings" class="sidebar-link"><i class="fas fa-gear"></i> Configurações</a>
  </nav>
  <div class="sidebar-footer"><a href="/admin/help" class="sidebar-link"><i class="fas fa-circle-question"></i> Ajuda</a></div>
</aside>

<header class="app-header">
  <div class="app-header-inner">
    <div></div>
    <nav class="app-header-nav">
      <a href="/" class="app-header-link">Home</a>
      <a href="/plugins" class="app-header-link">Marketplace</a>
      <a href="/sdk" class="app-header-link">SDK</a>
      <div class="user-menu">
        <button type="button" class="user-btn" id="user-toggle" title="<?= e($name) ?>">
          <svg class="user-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg>
        </button>
        <div class="user-dropdown" id="user-dropdown">
          <div class="user-info"><strong><?= e($name) ?></strong><small><?= e($email) ?></small></div>
          <form method="post" action="/logout"><button type="submit" class="user-logout"><i class="fas fa-sign-out-alt"></i> Sair</button></form>
        </div>
      </div>
    </nav>
  </div>
</header>

<main>

  <h1 style="margin:0 0 .3rem">Plugins</h1>
  <p style="color:#6b5544;margin:0 0 1rem">Gere os plugins do teu Beaver — ativar, desativar, instalar e remover.</p>

  <div class="stats">
    <div class="stat"><b><?= (int)$stats['installed_total'] ?></b><small>Instalados</small></div>
    <div class="stat"><b><?= (int)$stats['enabled'] ?></b><small>Ativos</small></div>
    <div class="stat"><b><?= (int)$stats['disabled'] ?></b><small>Inativos</small></div>
    <div class="stat"><b><?= (int)$stats['available'] ?></b><small>Disponíveis</small></div>
  </div>

  <h2 class="section">
    <i class="fas fa-check-circle" style="color:#16a34a"></i> Instalados
    <span class="count"><?= count($installed) ?></span>
  </h2>

  <div class="grid" id="installed-grid">
    <?php if (empty($installed)): ?>
      <div class="empty">Nenhum plugin instalado.</div>
    <?php else: foreach ($installed as $p): ?>
      <div class="card <?= $p['enabled'] ? '' : 'off' ?>" data-slug="<?= e($p['slug']) ?>">
        <div class="card-head">
          <div>
            <h3 class="card-title">
              <?= e($p['name']) ?>
              <?php if ($p['enabled']): ?>
                <span class="badge badge-on"><i class="fas fa-circle" style="font-size:.5rem"></i> ON</span>
              <?php else: ?>
                <span class="badge badge-off"><i class="fas fa-circle" style="font-size:.5rem"></i> OFF</span>
              <?php endif; ?>
            </h3>
            <div class="card-slug"><?= e($p['slug']) ?></div>
          </div>
        </div>

        <div class="card-meta">
          <span>v<?= e($p['version']) ?></span>
          <?php if ($p['is_native']): ?>
            <span class="badge badge-native">nativo</span>
          <?php else: ?>
            <span class="badge badge-external"><?= e($p['source']) ?></span>
          <?php endif; ?>
        </div>

        <div class="card-actions">
          <?php if ($p['is_self']): ?>
            <span style="font-size:.78rem;color:#a08f7a;font-style:italic">
              <i class="fas fa-lock"></i> Sistema
            </span>
          <?php else: ?>
            <button class="btn toggle-btn" data-slug="<?= e($p['slug']) ?>" data-action="<?= $p['enabled'] ? 'disable' : 'enable' ?>">
              <i class="fas fa-<?= $p['enabled'] ? 'pause' : 'play' ?>"></i>
              <?= $p['enabled'] ? 'Desativar' : 'Ativar' ?>
            </button>
            <button class="btn btn-danger remove-btn" data-slug="<?= e($p['slug']) ?>">
              <i class="fas fa-trash"></i> Remover
            </button>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <?php if (!empty($available)): ?>
    <h2 class="section">
      <i class="fas fa-box-open" style="color:#c25a1f"></i> Disponíveis no marketplace
      <span class="count"><?= count($available) ?></span>
    </h2>

    <div class="grid">
      <?php foreach ($available as $p): ?>
        <div class="card">
          <div class="card-head">
            <div>
              <h3 class="card-title"><?= e($p['icon']) ?> <?= e($p['name']) ?></h3>
              <div class="card-slug"><?= e($p['slug']) ?></div>
            </div>
          </div>
          <p style="margin:0;font-size:.85rem;color:#6b5544"><?= e($p['description']) ?></p>
          <div class="card-actions">
            <button class="btn btn-primary install-btn" data-slug="<?= e($p['slug']) ?>">
              <i class="fas fa-download"></i> Instalar
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <h2 class="section"><i class="fas fa-plus" style="color:#c25a1f"></i> Instalar de URL</h2>

  <div class="install-box">
    <p style="margin:0 0 .8rem;font-size:.85rem;color:#6b5544">
      Cola o URL de um repositório Git para instalar.
    </p>
    <form class="install-row" id="url-form">
      <input type="text" name="url" placeholder="https://github.com/user/meu-plugin.git" required>
      <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Instalar</button>
    </form>
  </div>

</main>

<div class="toast" id="toast"></div>

<script>
(function(){
  const toggle = document.getElementById('user-toggle');
  const drop   = document.getElementById('user-dropdown');
  if (toggle && drop) {
    toggle.addEventListener('click', (e) => { e.stopPropagation(); drop.classList.toggle('open'); });
    document.addEventListener('click', () => drop.classList.remove('open'));
  }

  const toast = document.getElementById('toast');
  function showToast(msg, isError) {
    toast.textContent = msg;
    toast.className = 'toast show' + (isError ? ' error' : '');
    setTimeout(() => toast.className = 'toast', 2500);
  }

  async function post(url, body) {
    const r = await fetch(url, {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: body ? JSON.stringify(body) : null
    });
    return r.json().catch(() => ({ ok: false, error: 'Resposta inválida' }));
  }

  document.querySelectorAll('.toggle-btn').forEach(b => b.addEventListener('click', async () => {
    const slug = b.dataset.slug;
    const action = b.dataset.action;
    const res = await post(`/admin/plugins/${slug}/${action}`);
    if (res.ok) { showToast(`${slug} ${action}d`); setTimeout(() => location.reload(), 500); }
    else showToast(res.error || 'Erro', true);
  }));

  document.querySelectorAll('.remove-btn').forEach(b => b.addEventListener('click', async () => {
    const slug = b.dataset.slug;
    if (!confirm(`Remover '${slug}'? Esta ação apaga a pasta do plugin.`)) return;
    const res = await post(`/admin/plugins/${slug}/remove`);
    if (res.ok) { showToast(`${slug} removido`); setTimeout(() => location.reload(), 500); }
    else showToast(res.error || 'Erro', true);
  }));

  document.querySelectorAll('.install-btn').forEach(b => b.addEventListener('click', async () => {
    const slug = b.dataset.slug;
    b.disabled = true;
    b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> A instalar...';
    const res = await post(`/admin/plugins/install`, { slug });
    if (res.ok) { showToast(`${slug} instalado`); setTimeout(() => location.reload(), 800); }
    else { showToast(res.error || 'Erro', true); b.disabled = false; b.innerHTML = '<i class="fas fa-download"></i> Instalar'; }
  }));

  const uf = document.getElementById('url-form');
  if (uf) uf.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(uf);
    const btn = uf.querySelector('button');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> A instalar...';
    const res = await post('/admin/plugins/install', { url: fd.get('url') });
    if (res.ok) { showToast('Instalado'); setTimeout(() => location.reload(), 800); }
    else { showToast(res.error || 'Erro', true); btn.disabled = false; btn.innerHTML = '<i class="fas fa-download"></i> Instalar'; }
  });
})();
</script>
</body>
</html>
