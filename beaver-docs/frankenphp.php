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
$pageTitle = 'FrankenPHP & Segurança';
$pageSubtitle = 'Runtime de alta performance com scanner de segurança integrado';
$activeSlug = 'frankenphp';
require __DIR__ . '/partials/head.php';
?>
<section class="beaver-section">
    <h2><i class="fas fa-server"></i>O que é o FrankenPHP no Beaver</h2>
    <div class="beaver-card">
        <p>
            O FrankenPHP é o runtime usado pelo Beaver Framework tanto em desenvolvimento como em produção — um servidor
            de aplicação PHP moderno (baseado em Caddy) com suporte a workers persistentes, HTTP/2, HTTP/3 e early hints.
        </p>
        <p class="mb-0">
            Além do papel de servidor, a integração do Beaver acrescenta uma <strong>camada de análise estática e
            dinâmica de segurança</strong>, acessível via CLI, que varre o código da aplicação em busca de vulnerabilidades
            comuns antes que cheguem a produção.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-rocket"></i>Servidor de desenvolvimento</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver serve                 # arranca com hot-reload
php beaver serve --workers=4     # modo worker, 4 processos persistentes
php beaver serve --https         # TLS automático (Caddy) em localhost</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-shield-halved"></i>Scanner de segurança — visão geral</h2>
    <div class="beaver-card">
        <p class="mb-2">Comando único para correr todas as análises disponíveis:</p>
        <pre><code class="language-bash">php beaver security:scan</code></pre>
        <pre><code class="language-text">🛡️  Beaver Security Scanner v1.0

[✓] SQL Injection ............... 0 problemas encontrados
[⚠] XSS .......................... 2 avisos (ver detalhes abaixo)
[✓] CSRF ......................... protegido em todas as rotas POST/PUT/DELETE
[⚠] Cabeçalhos HTTP .............. 1 aviso (CSP em falta)
[✓] Dependências (Composer) ...... 0 vulnerabilidades conhecidas
[✓] Segredos no código ........... nenhum segredo exposto encontrado
[✓] Configuração ................. APP_DEBUG=false em produção

Resumo: 3 avisos, 0 críticos — relatório completo em storage/security-report.html</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-database"></i>Deteção de SQL Injection</h2>
    <div class="beaver-card">
        <p class="mb-2">
            Análise estática do código à procura de queries construídas por concatenação direta de variáveis
            do pedido, em vez de bindings do ORM ou prepared statements:
        </p>
        <pre><code class="language-bash">php beaver security:sql-injection</code></pre>
        <pre><code class="language-php">// ❌ Detetado — concatenação direta de input do utilizador
$sql = "SELECT * FROM users WHERE email = '" . $request->input('email') . "'";
$db->query($sql);

// ✅ Não sinalizado — usa bindings/query builder
User::query()->where('email', $request->input('email'))->first();</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-code"></i>Deteção de XSS</h2>
    <div class="beaver-card">
        <p class="mb-2">Varre as views à procura de output não escapado de dados que chegam de input do utilizador:</p>
        <pre><code class="language-bash">php beaver security:xss</code></pre>
        <pre><code class="language-blade">{{-- ❌ Detetado — {!! !!} com dado vindo diretamente do request --}}
{!! $request->input('comentario') !!}

{{-- ✅ Seguro — escapado por omissão --}}
{{ $comentario }}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-user-shield"></i>CSRF</h2>
    <div class="beaver-card">
        <p class="mb-2">Confirma que todos os formulários com métodos que alteram estado incluem o token CSRF:</p>
        <pre><code class="language-blade">&lt;form method="POST" action="/artigos"&gt;
    @csrf
    ...
&lt;/form&gt;</code></pre>
        <p class="mb-0 text-muted small">Rotas POST/PUT/PATCH/DELETE sem <code class="inline-code">@csrf</code> correspondente na view são sinalizadas.</p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-file-shield"></i>Cabeçalhos de segurança HTTP</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver security:headers</code></pre>
        <p class="mb-2">Verifica a presença e configuração de:</p>
        <ul class="mb-0">
            <li><code class="inline-code">Content-Security-Policy</code></li>
            <li><code class="inline-code">Strict-Transport-Security</code></li>
            <li><code class="inline-code">X-Content-Type-Options: nosniff</code></li>
            <li><code class="inline-code">X-Frame-Options</code></li>
            <li><code class="inline-code">Referrer-Policy</code></li>
        </ul>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-key"></i>Segredos expostos no código</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver security:secrets</code></pre>
        <p class="mb-0">
            Procura padrões de chaves de API, tokens, passwords e connection strings escritos diretamente no código
            (em vez de <code class="inline-code">.env</code>), incluindo o histórico de commits recentes do git.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-boxes-stacked"></i>Dependências vulneráveis</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">php beaver security:dependencies</code></pre>
        <p class="mb-0">
            Cruza o <code class="inline-code">composer.lock</code> com bases de dados públicas de vulnerabilidades conhecidas
            (CVE) e assinala pacotes desatualizados com falhas reportadas.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-file-lines"></i>Relatório e integração contínua</h2>
    <div class="beaver-card">
        <pre><code class="language-bash"># Relatório HTML detalhado
php beaver security:scan --report=storage/security-report.html

# Modo CI — falha o build se houver problemas críticos
php beaver security:scan --fail-on=critical</code></pre>
        <pre><code class="language-yaml"># Exemplo: GitHub Actions
- name: Beaver Security Scan
  run: php beaver security:scan --fail-on=high</code></pre>
    </div>
</section>

<div class="beaver-card" style="border-left: 4px solid #8c3a2b; background: #fdf3f0;">
    <p class="mb-0 small">
        <i class="fas fa-triangle-exclamation me-1" style="color:#8c3a2b;"></i>
        O scanner é uma ferramenta de apoio para apanhar padrões comuns cedo no desenvolvimento — não substitui uma
        auditoria de segurança profissional nem testes de penetração antes de expor a aplicação em produção.
    </p>
</div>

<?php require __DIR__ . '/partials/foot.php'; ?>
