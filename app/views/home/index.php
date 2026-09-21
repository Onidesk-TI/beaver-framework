<div class="beaver-card">
    <h1>🦫 Beaver Framework</h1>
    <p>Bem-vindo! Versão <code><?= e(\Beaver\Foundation\Application::VERSION) ?></code>.</p>

    <h2>Estado atual</h2>
    <ul>
        <li>PHP: <code><?= e(PHP_VERSION) ?></code></li>
        <li>Ambiente: <code><?= e(config('app.env')) ?></code></li>
        <li>Timezone: <code><?= e(date_default_timezone_get()) ?></code></li>
        <li>Hora: <code><?= e(date('Y-m-d H:i:s')) ?></code></li>
    </ul>

    <h2>Views a funcionar 🎉</h2>
    <p>Este HTML foi renderizado via <code>View::make('home.index')</code>.</p>
    <p>O layout <code>layouts/main</code> foi aplicado automaticamente.</p>

    <?= view('partials.ping-button') ?>
</div>
