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
$pageTitle = 'Certify';
$pageSubtitle = 'Certificados HTTPS nativos do Beaver Framework';
$activeSlug = 'certify';
require __DIR__ . '/partials/head.php';
?>

<!-- ============================================================ -->
<!-- CSS ESPECÍFICO DA PÁGINA CERTIFY                              -->
<!-- ============================================================ -->
<style>
    :root {
        --beaver-walnut: #4A2C1D;
        --beaver-walnut-dark: #2E1A10;
        --beaver-oak: #A0693D;
        --beaver-oak-light: #C98A4F;
        --beaver-cream: #F5EBD8;
    }

    /* ---------- Tabs ---------- */
    .certify-tabs {
        border-bottom: 2px solid rgba(160, 105, 61, 0.25);
        gap: 4px;
        flex-wrap: wrap;
    }
    .certify-tabs .nav-link {
        color: var(--beaver-walnut);
        opacity: 0.65;
        border: none;
        border-bottom: 2px solid transparent;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.6rem 1rem;
        border-radius: 0;
        transition: all 0.2s ease;
        background: transparent;
    }
    .certify-tabs .nav-link i {
        margin-right: 6px;
        font-size: 0.85rem;
    }
    .certify-tabs .nav-link:hover {
        color: var(--beaver-oak);
        opacity: 1;
        border-bottom-color: var(--beaver-oak-light);
        background: rgba(201, 138, 79, 0.08);
    }
    .certify-tabs .nav-link.active {
        color: var(--beaver-oak);
        background: transparent;
        border-bottom-color: var(--beaver-oak);
        font-weight: 600;
        opacity: 1;
    }
    .tab-content {
        padding-top: 1.25rem;
    }

    /* ---------- Secções e cards ---------- */
    .beaver-section {
        margin-bottom: 2rem;
    }
    .beaver-section h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--beaver-walnut);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .beaver-section h2 i {
        color: var(--beaver-oak);
    }
    .beaver-card {
        background: #fff;
        border: 1px solid rgba(74, 44, 29, 0.12);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(74, 44, 29, 0.06);
    }

    /* ---------- Code blocks ---------- */
    .beaver-card pre {
        background: var(--beaver-walnut-dark);
        color: var(--beaver-cream);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-size: 0.85rem;
        line-height: 1.6;
        overflow-x: auto;
        margin: 0.5rem 0;
        border-left: 3px solid var(--beaver-oak);
    }
    .beaver-card pre code {
        color: inherit;
        background: transparent;
        padding: 0;
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    }
    .inline-code {
        background: rgba(160, 105, 61, 0.15);
        color: var(--beaver-oak);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.85em;
        font-family: 'Consolas', 'Monaco', monospace;
    }

    /* ---------- Output terminal ---------- */
    .certify-output {
        background: var(--beaver-walnut-dark);
        border-left: 3px solid var(--beaver-oak);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.82rem;
        line-height: 1.7;
        color: var(--beaver-cream);
        white-space: pre;
        overflow-x: auto;
    }
    .certify-output .ok    { color: #6ee7a8; }
    .certify-output .warn  { color: var(--beaver-oak-light); }
    .certify-output .err   { color: #f87171; }
    .certify-output .gray  { color: #a89684; }
    .certify-output .title { color: var(--beaver-oak-light); font-weight: 600; }

    /* ---------- Folder tree ---------- */
    .folder-tree {
        background: var(--beaver-cream);
        border: 1px solid rgba(74, 44, 29, 0.15);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.82rem;
        line-height: 1.7;
        color: var(--beaver-walnut);
        white-space: pre;
        overflow-x: auto;
    }

    /* ---------- Flow diagram ---------- */
    .flow {
        background: var(--beaver-cream);
        border-left: 3px solid var(--beaver-oak);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.8rem;
        line-height: 1.7;
        color: var(--beaver-walnut);
        white-space: pre;
        overflow-x: auto;
    }

    /* ---------- Listas ---------- */
    .beaver-card ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }
    .beaver-card ul li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--beaver-walnut);
    }
    .beaver-card ul li::before {
        content: "🦫";
        position: absolute;
        left: 0;
        font-size: 0.85rem;
    }

    /* ---------- Textos ---------- */
    .beaver-card p {
        color: var(--beaver-walnut);
        opacity: 0.9;
    }
    .beaver-card strong {
        color: var(--beaver-oak);
    }
    .beaver-card .text-muted,
    .beaver-card .small {
        color: var(--beaver-walnut) !important;
        opacity: 0.65;
    }
    .beaver-card .fw-bold {
        color: var(--beaver-walnut);
    }

    /* ---------- Alerta ---------- */
    .certify-alert {
        background: rgba(201, 138, 79, 0.12);
        border-left: 3px solid var(--beaver-oak);
        border-radius: 8px;
        padding: 0.9rem 1.1rem;
        color: var(--beaver-walnut);
        font-size: 0.9rem;
        margin: 1rem 0;
    }
    .certify-alert i {
        color: var(--beaver-oak);
        margin-right: 6px;
    }

    /* ---------- Responsivo ---------- */
    @media (max-width: 768px) {
        .certify-tabs .nav-link {
            font-size: 0.8rem;
            padding: 0.5rem 0.7rem;
        }
        .certify-tabs .nav-link i {
            margin-right: 4px;
        }
        .beaver-card pre,
        .folder-tree,
        .certify-output,
        .flow {
            font-size: 0.76rem;
        }
    }
</style>

<!-- ============================================================ -->
<!-- CONTEÚDO                                                      -->
<!-- ============================================================ -->

<section class="beaver-section">
    <h2><i class="fas fa-shield-alt"></i> O que é o Certify</h2>
    <div class="beaver-card">
        <p class="mb-2">
            O <strong>Certify</strong> é o módulo nativo de <strong>certificados HTTPS</strong> do Beaver Framework.
            Gera, instala, renova e verifica certificados TLS — tanto em desenvolvimento
            (<em>self-signed</em>) como em produção (<em>Let's Encrypt</em>).
        </p>
        <p class="mb-0">
            Um único comando (<code class="inline-code">php beaver certify:*</code>) trata de tudo:
            criar, instalar no Nginx/Apache, renovar via cron e verificar a saúde do TLS.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-book-open"></i> Documentação</h2>
    <div class="beaver-card">

        <!-- TABS -->
        <ul class="nav nav-tabs certify-tabs mb-2" id="certifyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-intro" data-bs-toggle="tab"
                        data-bs-target="#pane-intro" type="button" role="tab">
                    <i class="fas fa-play"></i> Introdução
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-config" data-bs-toggle="tab"
                        data-bs-target="#pane-config" type="button" role="tab">
                    <i class="fas fa-cog"></i> Configuração
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-selfsigned" data-bs-toggle="tab"
                        data-bs-target="#pane-selfsigned" type="button" role="tab">
                    <i class="fas fa-lock"></i> Self-Signed
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-letsencrypt" data-bs-toggle="tab"
                        data-bs-target="#pane-letsencrypt" type="button" role="tab">
                    <i class="fas fa-certificate"></i> Let's Encrypt
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-install" data-bs-toggle="tab"
                        data-bs-target="#pane-install" type="button" role="tab">
                    <i class="fas fa-server"></i> Instalar
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-check" data-bs-toggle="tab"
                        data-bs-target="#pane-check" type="button" role="tab">
                    <i class="fas fa-search"></i> Verificar
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-renew" data-bs-toggle="tab"
                        data-bs-target="#pane-renew" type="button" role="tab">
                    <i class="fas fa-sync-alt"></i> Renovar
                </button>
            </li>
        </ul>

        <div class="tab-content" id="certifyTabsContent">

            <!-- ============================================================ -->
            <!-- TAB 1 — INTRODUÇÃO                                            -->
            <!-- ============================================================ -->
            <div class="tab-pane fade show active" id="pane-intro" role="tabpanel">

                <p class="mb-3">
                    Tal como o <strong>Middleware</strong> processa pedidos HTTP, o <strong>Certify</strong>
                    processa <strong>certificados TLS</strong>. Ele:
                </p>

                <ul class="mb-3">
                    <li><strong>Gera</strong> certificados (self-signed para dev, Let's Encrypt para produção)</li>
                    <li><strong>Instala</strong> no servidor (Nginx/Apache) automaticamente</li>
                    <li><strong>Renova</strong> antes de expirar (via cron/ACME)</li>
                    <li><strong>Verifica</strong> validade, cadeia, protocolos suportados</li>
                    <li><strong>Reporta</strong> problemas (expiração, TLS antigo, HSTS em falta)</li>
                </ul>

                <p class="mb-1 fw-bold">Fluxo típico</p>
                <div class="flow">Desenvolvimento:
  1. php beaver certify:make meu-app.local      → gera self-signed
  2. php beaver certify:install meu-app.local   → configura Nginx/Apache
  3. Abrir https://meu-app.local                → ✅

Produção:
  1. php beaver certify:issue meu-app.com --email=admin@meu-app.com
  2. php beaver certify:install meu-app.com --server=nginx
  3. Configurar cron: php beaver certify:renew  → renova automaticamente</div>

                <div class="certify-alert">
                    <i class="fas fa-info-circle"></i>
                    <strong>Self-signed</strong> é para desenvolvimento local (browsers vão avisar).
                    <strong>Let's Encrypt</strong> é para produção (grátis, válido, sem avisos).
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 2 — CONFIGURAÇÃO                                          -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-config" role="tabpanel">

                <p class="mb-2"><code class="inline-code">config/certify.php</code>:</p>
                <pre><code class="language-php">return [
    'default' => env('CERTIFY_MODE', 'self-signed'),

    'modes' => [
        'self-signed' => [
            'driver'   => 'self-signed',
            'days'     => 365,
            'key_size' => 2048,
            'country'  => 'PT',
            'org'      => 'Beaver Local',
        ],
        'letsencrypt' => [
            'driver'     => 'acme',
            'email'      => env('CERTIFY_EMAIL'),
            'provider'   => 'letsencrypt',
            'challenge'  => 'http-01',   // ou 'dns-01'
            'renew_days' => 30,
        ],
    ],

    'paths' => [
        'storage' => storage_path('certificates'),
        'nginx'   => '/etc/nginx/snippets',
        'apache'  => '/etc/apache2/sites-available',
    ],

    'tls' => [
        'min_version'  => 'TLSv1.2',
        'ciphers'      => 'HIGH:!aNULL:!MD5',
        'hsts'         => true,
        'hsts_max_age' => 31536000,
    ],
];</code></pre>

                <p class="mt-3 mb-2">Variáveis no <code class="inline-code">.env</code>:</p>
                <pre><code class="language-ini">CERTIFY_MODE=self-signed
CERTIFY_EMAIL=admin@meu-app.com</code></pre>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 3 — SELF-SIGNED                                           -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-selfsigned" role="tabpanel">

                <p class="mb-2">
                    Para desenvolvimento local. Gera <code class="inline-code">.crt</code> e
                    <code class="inline-code">.key</code> válidos por 1 ano.
                </p>

                <p class="mb-1 fw-bold">Comando</p>
                <pre><code class="language-bash">php beaver certify:make meu-app.local</code></pre>

                <p class="mt-3 mb-1 fw-bold">Opções</p>
                <pre><code class="language-bash">php beaver certify:make meu-app.local \
    --days=365 \
    --key-size=2048 \
    --force</code></pre>

                <p class="mt-3 mb-1 fw-bold">O que é criado</p>
                <div class="folder-tree">storage/certificates/
├── meu-app.local.crt     ← certificado público
├── meu-app.local.key     ← chave privada (NUNCA partilhar!)
└── ca.crt                ← CA local (para confiar no browser)</div>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="certify-output"><span class="ok">✅ Certificado gerado:</span>
   Domínio:  meu-app.local
   Expira:   2027-03-10 (365 dias)
   CRT:      storage/certificates/meu-app.local.crt
   KEY:      storage/certificates/meu-app.local.key</div>

                <p class="mt-3 mb-1 fw-bold">Confiar no browser (opcional)</p>
                <pre><code class="language-bash"># Linux (Chrome/Firefox)
sudo cp storage/certificates/ca.crt /usr/local/share/ca-certificates/beaver-ca.crt
sudo update-ca-certificates

# Windows
# Importar ca.crt em "Autoridades de Certificação de Raiz Fidedignas"

# macOS
sudo security add-trusted-cert -d -r trustRoot \
    -k /Library/Keychains/System.keychain \
    storage/certificates/ca.crt</code></pre>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 4 — LET'S ENCRYPT                                         -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-letsencrypt" role="tabpanel">

                <p class="mb-2">
                    Para produção. Certificado <strong>grátis, válido e reconhecido</strong> por todos os browsers.
                    Renova automaticamente a cada 90 dias.
                </p>

                <p class="mb-1 fw-bold">Requisitos</p>
                <ul class="mb-3">
                    <li>Domínio público a apontar para o servidor (ex: <code class="inline-code">meu-app.com</code>)</li>
                    <li>Porta 80 aberta (para o desafio HTTP-01)</li>
                    <li>Email válido para notificações</li>
                </ul>

                <p class="mb-1 fw-bold">Emitir certificado</p>
                <pre><code class="language-bash">php beaver certify:issue meu-app.com --email=admin@meu-app.com</code></pre>

                <p class="mt-3 mb-1 fw-bold">Desafio DNS (alternativa)</p>
                <pre><code class="language-bash">php beaver certify:issue meu-app.com \
    --email=admin@meu-app.com \
    --challenge=dns-01</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="certify-output"><span class="ok">✅ Certificado Let's Encrypt emitido:</span>
   Domínio:  meu-app.com
   Expira:   2026-06-10 (90 dias)
   Emissor:  Let's Encrypt Authority X3
   CRT:      storage/certificates/meu-app.com.crt
   KEY:      storage/certificates/meu-app.com.key

<span class="warn">⚠️  Renovação automática configurada em 30 dias antes de expirar</span></div>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 5 — INSTALAR                                              -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-install" role="tabpanel">

                <p class="mb-2">
                    Instala o certificado no servidor web e aplica as boas práticas TLS.
                </p>

                <p class="mb-1 fw-bold">Nginx</p>
                <pre><code class="language-bash">php beaver certify:install meu-app.local --server=nginx</code></pre>

                <p class="mb-2">Gera <code class="inline-code">/etc/nginx/snippets/meu-app.local-ssl.conf</code>:</p>
                <pre><code class="language-nginx">listen 443 ssl http2;
listen [::]:443 ssl http2;

ssl_certificate     /var/www/meu-app/storage/certificates/meu-app.local.crt;
ssl_certificate_key /var/www/meu-app/storage/certificates/meu-app.local.key;

ssl_protocols TLSv1.2 TLSv1.3;
ssl_ciphers HIGH:!aNULL:!MD5;
ssl_prefer_server_ciphers on;

# HSTS (força HTTPS por 1 ano)
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

# OCSP Stapling
ssl_stapling on;
ssl_stapling_verify on;</code></pre>

                <p class="mt-3 mb-1 fw-bold">Apache</p>
                <pre><code class="language-bash">php beaver certify:install meu-app.local --server=apache</code></pre>

                <p class="mb-2">Gera <code class="inline-code">/etc/apache2/sites-available/meu-app.local-ssl.conf</code>:</p>
                <pre><code class="language-apache">&lt;VirtualHost *:443&gt;
    ServerName meu-app.local
    DocumentRoot /var/www/meu-app/public

    SSLEngine on
    SSLCertificateFile      /var/www/meu-app/storage/certificates/meu-app.local.crt
    SSLCertificateKeyFile   /var/www/meu-app/storage/certificates/meu-app.local.key

    SSLProtocol             all -SSLv3 -TLSv1 -TLSv1.1
    SSLCipherSuite          HIGH:!aNULL:!MD5
    SSLHonorCipherOrder     on

    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
&lt;/VirtualHost&gt;</code></pre>

                <p class="mt-3 mb-1 fw-bold">Recarregar servidor</p>
                <pre><code class="language-bash"># Nginx
sudo nginx -t && sudo systemctl reload nginx

# Apache
sudo apachectl configtest && sudo systemctl reload apache2</code></pre>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 6 — VERIFICAR                                             -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-check" role="tabpanel">

                <p class="mb-2">
                    Verifica a saúde do certificado: validade, cadeia, protocolos, HSTS.
                </p>

                <p class="mb-1 fw-bold">Comando</p>
                <pre><code class="language-bash">php beaver certify:check meu-app.local</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="certify-output"><span class="title">🦫 Beaver Certify — Verificação</span>

Domínio:  meu-app.local
Validade: 2026-03-10 → 2027-03-10 (364 dias)
Emissor:  Beaver Local CA
TLS:      TLSv1.3 <span class="ok">✅</span>
Cifras:   TLS_AES_256_GCM_SHA384 <span class="ok">✅</span>
Cadeia:   Válida <span class="ok">✅</span>
HSTS:     Ativo <span class="ok">✅</span>

<span class="warn">⚠️  Avisos:</span>
   • Certificado self-signed (esperado em dev)

<span class="ok">✅ Sem problemas críticos</span></div>

                <p class="mt-3 mb-1 fw-bold">Verificação completa (todos os domínios)</p>
                <pre><code class="language-bash">php beaver certify:check --all</code></pre>

                <p class="mb-2">Output:</p>
                <div class="certify-output"><span class="title">🦫 Beaver Certify — Todos os certificados</span>

<span class="ok">✅</span> meu-app.local        364 dias    TLSv1.3   HSTS ✅
<span class="warn">⚠️</span>  api.meu-app.local     30 dias    TLSv1.2   HSTS ❌
<span class="err">❌</span> old.meu-app.local    expirado   —         —</div>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 7 — RENOVAR                                               -->
            <!-- ============================================================ -->
            <div class="tab-pane fade" id="pane-renew" role="tabpanel">

                <p class="mb-2">
                    Renova certificados antes de expirarem. Para Let's Encrypt, corre via cron.
                </p>

                <p class="mb-1 fw-bold">Renovação manual</p>
                <pre><code class="language-bash">php beaver certify:renew
php beaver certify:renew --force
php beaver certify:renew meu-app.local</code></pre>

                <p class="mt-3 mb-1 fw-bold">Automatizar via cron</p>
                <pre><code class="language-bash">sudo crontab -e</code></pre>
                <p class="mb-2">Adicionar:</p>
                <pre><code class="language-cron"># Renovar certificados todos os dias às 3h da manhã
0 3 * * * cd /var/www/meu-app && php beaver certify:renew >> storage/logs/certify.log 2>&1</code></pre>

                <p class="mt-3 mb-1 fw-bold">Systemd timer (alternativa)</p>
                <pre><code class="language-ini"># /etc/systemd/system/beaver-certify-renew.service
[Unit]
Description=Beaver Certify — Renovação automática
After=network.target

[Service]
Type=oneshot
WorkingDirectory=/var/www/meu-app
ExecStart=/usr/bin/php beaver certify:renew</code></pre>

                <pre><code class="language-ini"># /etc/systemd/system/beaver-certify-renew.timer
[Unit]
Description=Renova certificados diariamente

[Timer]
OnCalendar=daily
Persistent=true

[Install]
WantedBy=timers.target</code></pre>

                <pre><code class="language-bash">sudo systemctl enable --now beaver-certify-renew.timer</code></pre>
            </div>

        </div>
        <!-- /tab-content -->

    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i> Comandos disponíveis</h2>
    <div class="beaver-card">
        <pre><code class="language-bash"># Gerar self-signed (dev)
php beaver certify:make meu-app.local

# Emitir Let's Encrypt (produção)
php beaver certify:issue meu-app.com --email=admin@meu-app.com

# Instalar no servidor
php beaver certify:install meu-app.local --server=nginx
php beaver certify:install meu-app.local --server=apache

# Verificar saúde
php beaver certify:check meu-app.local
php beaver certify:check --all

# Renovar
php beaver certify:renew
php beaver certify:renew --force

# Listar todos
php beaver certify:list</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-folder-tree"></i> Estrutura recomendada</h2>
    <div class="beaver-card">
        <div class="folder-tree">meu-projeto/
├── config/
│   └── certify.php                # configuração do módulo
├── storage/
│   └── certificates/              # certificados gerados
│       ├── meu-app.local.crt
│       ├── meu-app.local.key
│       └── ca.crt
├── app/
│   └── Commands/
│       ├── CertifyMakeCommand.php
│       ├── CertifyIssueCommand.php
│       ├── CertifyInstallCommand.php
│       ├── CertifyCheckCommand.php
│       └── CertifyRenewCommand.php
└── beaver                         # CLI</div>
        <p class="mt-2 mb-0 text-muted small">
            Os certificados ficam em <code class="inline-code">storage/certificates/</code>.
            Nunca commitar a chave privada (<code class="inline-code">.key</code>) para o Git.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-vial"></i> Testar com Unity Test</h2>
    <div class="beaver-card">
        <pre><code class="language-php">use Beaver\Testing\UnityTest;
use Beaver\Certify\CertificateManager;

UnityTest::describe('Certify', function () {

    UnityTest::test('gera certificado self-signed', function () {
        $cert = Certify::make('test.local', days: 30);

        UnityTest::assertTrue(file_exists($cert->crtPath()));
        UnityTest::assertTrue(file_exists($cert->keyPath()));
    });

    UnityTest::test('certificado expira no prazo definido', function () {
        $cert = Certify::make('test.local', days: 30);

        $expected = now()->addDays(30)->format('Y-m-d');
        UnityTest::assertSame($expected, $cert->expiresAt()->format('Y-m-d'));
    });

    UnityTest::test('deteta certificado expirado', function () {
        $cert = Certify::make('test.local', days: -1);

        UnityTest::assertFalse($cert->isValid());
    });

});</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-flag-checkered"></i> Boas práticas</h2>
    <div class="beaver-card">
        <ul class="mb-0">
            <li>Usa <strong>self-signed</strong> apenas em desenvolvimento.</li>
            <li>Usa <strong>Let's Encrypt</strong> em produção (grátis e válido).</li>
            <li>Nunca commitar <code class="inline-code">.key</code> para o Git.</li>
            <li>Ativa <strong>HSTS</strong> para forçar HTTPS.</li>
            <li>Força <strong>TLS 1.2+</strong> (nunca TLS 1.0/1.1).</li>
            <li>Configura renovação automática (cron ou systemd timer).</li>
            <li>Monitoriza expiração com <code class="inline-code">certify:check --all</code>.</li>
        </ul>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>

