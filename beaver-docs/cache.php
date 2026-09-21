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
$pageTitle = 'Cache';
$pageSubtitle = 'Camada de cache com múltiplos drivers e API unificada';
$activeSlug = 'cache';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-bolt"></i>Configuração</h2>
    <div class="beaver-card">
        <p class="mb-2"><code class="inline-code">config/cache.php</code>:</p>
        <pre><code class="language-php">return [
    'default' => env('CACHE_DRIVER', 'file'),

    'stores' => [
        'file'  => ['driver' => 'file', 'path' => storage_path('cache')],
        'array' => ['driver' => 'array'],   // só em memória, útil em testes
        'redis' => ['driver' => 'redis', 'connection' => 'default'],
    ],
];</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-code"></i>API básica</h2>
    <div class="beaver-card">
        <pre><code class="language-php">use Beaver\Support\Cache;

// Guardar por 10 minutos
Cache::put('artigos.recentes', $articles, 600);

// Ler (com valor por omissão se não existir)
$articles = Cache::get('artigos.recentes', []);

// Remember — busca do cache ou executa e guarda
$articles = Cache::remember('artigos.recentes', 600, function () {
    return Article::query()->where('published', true)->latest()->take(10)->get();
});

// Verificar existência / remover
if (Cache::has('artigos.recentes')) {
    Cache::forget('artigos.recentes');
}

// Guardar para sempre / incrementar contadores
Cache::forever('config.versao', '1.4.0');
Cache::increment('artigo.5.views');</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-layer-group"></i>Tags de cache</h2>
    <div class="beaver-card">
        <pre><code class="language-php">Cache::tags(['artigos', 'homepage'])->put('lista.destaque', $articles, 3600);

// Invalidar tudo o que tem a tag "artigos" (ex: ao criar/editar um artigo)
Cache::tags('artigos')->flush();</code></pre>
        <p class="mt-2 mb-0 text-muted small">Tags só estão disponíveis nos drivers <code class="inline-code">redis</code> e <code class="inline-code">array</code> — o driver <code class="inline-code">file</code> ignora-as silenciosamente.</p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i>Comandos úteis</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver cache:clear          # limpa toda a cache da aplicação
php beaver cache:forget chave   # remove uma chave específica
php beaver route:cache          # faz cache das rotas compiladas (produção)
php beaver view:cache           # pré-compila as views Blade</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
