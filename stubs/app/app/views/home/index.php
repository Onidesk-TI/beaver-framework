<!DOCTYPE html>
<html lang="pt" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Beaver') ?></title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:system-ui,-apple-system,sans-serif;background:#FAFAF7;color:#1A1208;line-height:1.65;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
        .card{max-width:560px;background:#fff;border:1px solid rgba(26,18,8,.10);border-radius:18px;padding:40px 36px;box-shadow:0 20px 40px -24px rgba(26,18,8,.25)}
        .logo{font-size:3rem;text-align:center;margin-bottom:12px}
        h1{font-size:1.6rem;font-weight:800;letter-spacing:-.03em;text-align:center;margin-bottom:8px}
        .sub{color:#6B6B5F;text-align:center;margin-bottom:28px;font-size:.95rem}
        .meta{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;margin-bottom:24px;font-family:ui-monospace,monospace;font-size:.75rem}
        .pill{padding:5px 12px;border-radius:100px;background:rgba(255,107,53,.10);color:#E07800;border:1px solid rgba(255,107,53,.25);font-weight:700}
        .links{display:flex;flex-direction:column;gap:8px;margin-top:20px}
        .links a{display:flex;justify-content:space-between;padding:12px 16px;border-radius:10px;background:#FAFAF7;border:1px solid rgba(26,18,8,.08);color:inherit;text-decoration:none;transition:.15s;font-size:.92rem}
        .links a:hover{background:#F4F4EE;border-color:rgba(255,107,53,.35);transform:translateX(2px)}
        .links code{font-family:ui-monospace,monospace;font-size:.85em;color:#E07800}
        footer{text-align:center;color:#6B6B5F;font-size:.82rem;margin-top:28px;padding-top:20px;border-top:1px solid rgba(26,18,8,.08)}
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">🦫</div>
        <h1>Beaver está a funcionar</h1>
        <p class="sub">A tua aplicação foi criada e está pronta a desenvolver.</p>

        <div class="meta">
            <span class="pill">v<?= beaver_version() ?></span>
            <span class="pill"><?= htmlspecialchars(getenv('APP_ENV') ?: 'local') ?></span>
        </div>

        <div class="links">
            <a href="/health" target="_blank">
                <span>Health check (JSON)</span>
                <code>/health</code>
            </a>
            <a href="https://github.com/Frank-Onidesk/beaver-framework" target="_blank" rel="noopener">
                <span>Documentação do framework</span>
                <code>github.com/Frank-Onidesk</code>
            </a>
        </div>

        <footer>
            Próximo passo: <code>./beaver help</code> para ver todos os comandos
        </footer>
    </div>
</body>
</html>
