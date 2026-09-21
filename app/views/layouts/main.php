<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Beaver') ?> — Beaver Framework</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: -apple-system, 'Segoe UI', Roboto, sans-serif; background: #FAF6EF; color: #2E1A10; line-height: 1.5; }
        .beaver-nav { background: #4A2C1D; color: #F5EBD8; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .beaver-nav a { color: #F5EBD8; text-decoration: none; margin-right: 1.5rem; }
        .beaver-nav a:hover { color: #C98A4F; }
        .beaver-nav .logo { font-weight: 700; font-size: 1.1rem; }
        .beaver-container { max-width: 960px; margin: 2rem auto; padding: 0 1.5rem; }
        .beaver-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(74,44,29,0.08); }
        h1, h2 { color: #2E1A10; }
        code { background: #F5EBD8; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
    </style>
</head>
<body>
    <nav class="beaver-nav">
        <a href="/" class="logo">🦫 Beaver</a>
        <div>
            <a href="/">Home</a>
            <a href="/home">Views</a>
            <a href="/ping">Ping</a>
        </div>
    </nav>
    <main class="beaver-container">
        <?= $content ?>
    </main>
</body>
</html>
