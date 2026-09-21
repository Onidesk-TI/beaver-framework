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
$pageTitle = 'DbScope';
$pageSubtitle = 'Análise profunda da base de dados do Beaver Framework';
$activeSlug = 'dbscope';
require __DIR__ . '/partials/head.php';
?>

<style>
    :root {
        --beaver-walnut: #4A2C1D;
        --beaver-walnut-dark: #2E1A10;
        --beaver-oak: #A0693D;
        --beaver-oak-light: #C98A4F;
        --beaver-cream: #F5EBD8;
    }

    .dbscope-tabs {
        border-bottom: 2px solid rgba(160, 105, 61, 0.25);
        gap: 4px;
        flex-wrap: wrap;
    }
    .dbscope-tabs .nav-link {
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
.dbscope-tabs .nav-link i {
    margin-right: 6px;
    font-size: 0.85rem;
}
.dbscope-tabs .nav-link:hover {
    color: var(--beaver-oak);
    opacity: 1;
    border-bottom-color: var(--beaver-oak-light);
    background: rgba(201, 138, 79, 0.08);
}
.dbscope-tabs .nav-link.active {
    color: var(--beaver-oak);
    background: transparent;
    border-bottom-color: var(--beaver-oak);
    font-weight: 600;
    opacity: 1;
}
    .tab-content { padding-top: 1.25rem; }

    .beaver-section { margin-bottom: 2rem; }
    .beaver-section h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--beaver-walnut);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .beaver-section h2 i { color: var(--beaver-oak); }
    .beaver-card {
        background: #fff;
        border: 1px solid rgba(74, 44, 29, 0.12);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(74, 44, 29, 0.06);
    }
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

    .dbscope-output {
        background: var(--beaver-walnut-dark);
        border-left: 3px solid var(--beaver-oak);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.8rem;
        line-height: 1.7;
        color: var(--beaver-cream);
        white-space: pre;
        overflow-x: auto;
    }
    .dbscope-output .ok    { color: #6ee7a8; }
    .dbscope-output .warn  { color: var(--beaver-oak-light); }
    .dbscope-output .err   { color: #f87171; }
    .dbscope-output .gray  { color: #a89684; }
    .dbscope-output .title { color: var(--beaver-oak-light); font-weight: 600; }
    .dbscope-output .num   { color: #fbbf24; }

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

    .beaver-card ul { list-style: none; padding-left: 0; margin: 0; }
    .beaver-card ul li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--beaver-walnut);
    }
    .beaver-card ul li::before {
        content: "";
        position: absolute;
        left: 0;
        font-size: 0.85rem;
    }
    .beaver-card ul:not(.nav-tabs) li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
    color: var(--beaver-walnut);
}
.beaver-card ul:not(.nav-tabs) li::before {
    content: "🦫";
    position: absolute;
    left: 0;
    font-size: 0.85rem;
}
    .beaver-card p { color: var(--beaver-walnut); opacity: 0.9; }
    .beaver-card strong { color: var(--beaver-oak); }
    .beaver-card .text-muted,
    .beaver-card .small {
        color: var(--beaver-walnut) !important;
        opacity: 0.65;
    }
    .beaver-card .fw-bold { color: var(--beaver-walnut); }

    .dbscope-alert {
        background: rgba(201, 138, 79, 0.12);
        border-left: 3px solid var(--beaver-oak);
        border-radius: 8px;
        padding: 0.9rem 1.1rem;
        color: var(--beaver-walnut);
        font-size: 0.9rem;
        margin: 1rem 0;
    }
    .dbscope-alert i { color: var(--beaver-oak); margin-right: 6px; }

    @media (max-width: 768px) {
        .dbscope-tabs .nav-link { font-size: 0.8rem; padding: 0.5rem 0.7rem; }
        .dbscope-tabs .nav-link i { margin-right: 4px; }
        .beaver-card pre, .folder-tree, .dbscope-output { font-size: 0.74rem; }
    }
</style>

<section class="beaver-section">
    <h2><i class="fas fa-database"></i> O que é o DbScope</h2>
    <div class="beaver-card">
        <p class="mb-2">
            O <strong>DbScope</strong> é o módulo de <strong>análise profunda da base de dados</strong>
            do Beaver Framework. Enquanto o <strong>FrankeiPHP</strong> analisa código-fonte e o
            <strong>Certify</strong> trata de TLS, o DbScope vai <strong>dentro do MySQL/MariaDB</strong>
            e analisa tudo.
        </p>
        <p class="mb-0">
            Um único comando (<code class="inline-code">php beaver dbscope:scan</code>) gera um relatório
            completo de <strong>tabelas, índices, relações, procedures, triggers, views, eventos,
            utilizadores, performance e segurança</strong>.
        </p>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-book-open"></i> Documentação</h2>
    <div class="beaver-card">
<ul class="nav nav-tabs dbscope-tabs mb-2" id="dbscopeTabs" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pane-intro"><i class="fas fa-play"></i> Introdução</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-tables"><i class="fas fa-table"></i> Tabelas</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-indexes"><i class="fas fa-key"></i> Índices</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-relations"><i class="fas fa-link"></i> Relações</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-procedures"><i class="fas fa-code"></i> Procedures</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-triggers"><i class="fas fa-bolt"></i> Triggers</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-views"><i class="fas fa-eye"></i> Views</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-performance"><i class="fas fa-tachometer-alt"></i> Performance</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pane-security"><i class="fas fa-lock"></i> Segurança</button></li>
</ul>

        <div class="tab-content" id="dbscopeTabsContent">

            <div class="tab-pane fade show active" id="pane-intro" role="tabpanel">
                <p class="mb-3">O DbScope analisa <strong>10 categorias</strong> da base de dados:</p>
                <div class="folder-tree">1.  Tabelas       → estrutura, tamanho, fragmentação
2.  Índices       → primários, únicos, duplicados, em falta
3.  Relações      → foreign keys, ON DELETE/UPDATE, órfãos
4.  Procedures    → stored procedures, funções, SQL dinâmico
5.  Triggers      → eventos, tabelas afetadas, erros
6.  Views         → dependências, complexidade, órfãs
7.  Eventos       → agendamentos, status, próximas execuções
8.  Utilizadores  → permissões, hosts, contas de teste
9.  Performance   → slow queries, cache hit ratio, table scans
10. Segurança     → hashing, colunas sensíveis, SSL, binlogs</div>

                <p class="mt-3 mb-1 fw-bold">Comando principal</p>
                <pre><code class="language-bash">php beaver dbscope:scan</code></pre>

                <div class="dbscope-alert">
                    <i class="fas fa-info-circle"></i>
                    O DbScope é <strong>read-only</strong>. Nunca altera nada na base de dados.
                    Apenas lê e reporta.
                </div>
            </div>

            <div class="tab-pane fade" id="pane-tables" role="tabpanel">
                <p class="mb-2">Analisa estrutura, tamanho, comentários e fragmentação.</p>
                <pre><code class="language-bash">php beaver dbscope:tables
php beaver dbscope:tables --table=users</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">📦 TABELAS (12)</span>
<span class="gray">─────────────────────────────────────────────────</span>
  users              <span class="num">3.2 MB</span>   <span class="num">1.245</span> rows   InnoDB   <span class="ok">OK</span>
  orders             <span class="num">8.7 MB</span>   <span class="num">5.432</span> rows   InnoDB   <span class="ok">OK</span>
  order_items       <span class="num">12.1 MB</span>  <span class="num">18.221</span> rows   InnoDB   <span class="warn">fragmentada 34%</span>
  sessions           <span class="num">0.8 MB</span>     <span class="num">890</span> rows   InnoDB   <span class="warn">sem PRIMARY KEY</span>
  logs              <span class="num">45.3 MB</span> <span class="num">120.000</span> rows   InnoDB   <span class="warn">sem índice</span></div>

                <p class="mt-3 mb-1 fw-bold">O que verifica</p>
                <ul>
                    <li>Engine (InnoDB vs MyISAM)</li>
                    <li>Collation (utf8mb4 vs utf8)</li>
                    <li>Tamanho (dados + índices)</li>
                    <li>Fragmentação (DATA_FREE)</li>
                    <li>Colunas sem comentário</li>
                    <li>Primary keys em falta</li>
                </ul>
            </div>

            <div class="tab-pane fade" id="pane-indexes" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:indexes</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">🔑 ÍNDICES</span>
<span class="gray">─────────────────────────────────────────────────</span>
  <span class="ok">OK</span> 28 índices válidos

  <span class="warn">3 índices duplicados:</span>
      • users: idx_email + users_email_unique
      • orders: idx_user + fk_orders_user
      • products: idx_name + products_name_index

  <span class="err">4 tabelas sem PRIMARY KEY:</span>
      • sessions, logs, audit, cache

  <span class="warn">5 FKs sem índice no lado referenciado:</span>
      • order_items.product_id
      • users.role_id
      • posts.category_id</div>

                <p class="mt-3 mb-1 fw-bold">Sugestões geradas</p>
                <pre><code class="language-sql">-- Remover índice duplicado
DROP INDEX idx_email ON users;

-- Adicionar índice em falta
CREATE INDEX idx_order_items_product ON order_items(product_id);

-- Adicionar PRIMARY KEY
ALTER TABLE sessions ADD PRIMARY KEY (id);</code></pre>
            </div>

            <div class="tab-pane fade" id="pane-relations" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:relations</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">🔗 RELAÇÕES (FOREIGN KEYS)</span>
<span class="gray">─────────────────────────────────────────────────</span>
  <span class="ok">OK</span> 14 foreign keys corretas

  <span class="warn">ON DELETE CASCADE em colunas sensíveis:</span>
      • orders.user_id → users.id (CASCADE)
      • order_items.order_id → orders.id (CASCADE)

  <span class="warn">2 relações sem índice:</span>
      • order_items.product_id
      • users.role_id

  <span class="err">Registos órfãos detetados:</span>
      • order_items.product_id = 999 (produto não existe)
      • posts.category_id = 42 (categoria apagada)</div>

                <p class="mt-3 mb-1 fw-bold">Sugestões</p>
                <pre><code class="language-sql">-- Adicionar ON DELETE SET NULL em vez de CASCADE
ALTER TABLE orders DROP FOREIGN KEY fk_orders_user;
ALTER TABLE orders ADD CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Limpar órfãos
DELETE FROM order_items WHERE product_id NOT IN (SELECT id FROM products);</code></pre>
            </div>

            <div class="tab-pane fade" id="pane-procedures" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:procedures</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">⚙️  PROCEDURES (3)</span>
<span class="gray">─────────────────────────────────────────────────</span>
  <span class="ok">OK</span> sp_calculate_total       (5 linhas)
  <span class="warn">!</span>  sp_cleanup_logs          usa SQL dinâmico
  <span class="err">X</span>  sp_old_import            nunca chamada em 12 meses

  <span class="title">Detalhes sp_cleanup_logs:</span>
      Definidor:  app_user@localhost
      Segurança:  DEFINER  <span class="warn">corre com permissões do criador</span>
      Linhas:     42
      Avisos:
        • Usa PREPARE/EXECUTE (risco de injection)
        • Não trata erros (sem HANDLER)</div>

                <p class="mt-3 mb-1 fw-bold">O que verifica</p>
                <ul>
                    <li>SQL dinâmico (PREPARE/EXECUTE)</li>
                    <li>SECURITY DEFINER vs INVOKER</li>
                    <li>Cursors sem CLOSE</li>
                    <li>Procedures órfãs (nunca chamadas)</li>
                    <li>Complexidade (número de linhas)</li>
                </ul>
            </div>

            <div class="tab-pane fade" id="pane-triggers" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:triggers</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">🎯 TRIGGERS (2)</span>
<span class="gray">─────────────────────────────────────────────────</span>
  <span class="ok">OK</span> trg_users_updated_at     BEFORE UPDATE em users
  <span class="warn">!</span>  trg_orders_audit         AFTER INSERT em orders
      Avisos:
        • Sem tratamento de erro (HANDLER)
        • Faz INSERT em audit_log — pode falhar se a tabela estiver bloqueada</div>

                <p class="mt-3 mb-1 fw-bold">O que verifica</p>
                <ul>
                    <li>Timing (BEFORE/AFTER) e evento (INSERT/UPDATE/DELETE)</li>
                    <li>Triggers sem HANDLER</li>
                    <li>Triggers que escrevem noutras tabelas</li>
                    <li>Triggers duplicados</li>
                </ul>
            </div>

            <div class="tab-pane fade" id="pane-views" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:views</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">👁️  VIEWS (4)</span>
<span class="gray">─────────────────────────────────────────────────</span>
  <span class="ok">OK</span> vw_active_users
  <span class="ok">OK</span> vw_order_summary
  <span class="warn">!</span>  vw_product_stock        referência circular detetada
  <span class="err">X</span>  vw_old_report            view órfã (tabela base não existe)</div>

                <p class="mt-3 mb-1 fw-bold">O que verifica</p>
                <ul>
                    <li>Tabelas base existem</li>
                    <li>Referências circulares</li>
                    <li>Views órfãs</li>
                    <li>Complexidade (JOINs, subqueries)</li>
                    <li>Views sem índice na tabela base</li>
                </ul>
            </div>

            <div class="tab-pane fade" id="pane-performance" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:performance</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">⚡ PERFORMANCE</span>
<span class="gray">─────────────────────────────────────────────────</span>
  Cache hit ratio:        <span class="ok">98.7%</span>
  Slow queries (>1s):     <span class="warn">12</span>
  Table scans completos:  <span class="warn">3</span>
  Conexões ativas:        <span class="ok">5</span>/100
  InnoDB buffer pool:     <span class="ok">1.2 GB</span>/2 GB (60%)

  <span class="title">Top 3 queries lentas:</span>
     1. <span class="num">4.2s</span> SELECT * FROM order_items WHERE ... (sem índice)
     2. <span class="num">2.8s</span> SELECT COUNT(*) FROM logs WHERE ... (table scan)
     3. <span class="num">1.9s</span> JOIN users + orders (índice em falta)

  <span class="title">Sugestões:</span>
     • Aumentar innodb_buffer_pool_size para 3 GB
     • Adicionar índice: order_items(created_at)
     • Particionar tabela logs por data</div>
            </div>

            <div class="tab-pane fade" id="pane-security" role="tabpanel">
                <pre><code class="language-bash">php beaver dbscope:security</code></pre>

                <p class="mt-3 mb-1 fw-bold">Output</p>
                <div class="dbscope-output"><span class="title">🔒 SEGURANÇA</span>
<span class="gray">─────────────────────────────────────────────────</span>
  <span class="ok">OK</span> Passwords com bcrypt (users.password VARCHAR(255))
  <span class="warn">!</span>  Colunas sensíveis sem encriptação:
      • users.cpf
      • orders.credit_card
      • customers.iban

  <span class="err">X</span>  SSL/TLS desativado na ligação MySQL
  <span class="err">X</span>  Binlogs desativados (sem point-in-time recovery)
  <span class="warn">!</span>  Utilizador root@% exposto na rede
  <span class="err">X</span>  Conta de teste ativa: test@localhost</div>

                <p class="mt-3 mb-1 fw-bold">Sugestões geradas</p>
                <pre><code class="language-sql">-- Encriptar colunas sensíveis
ALTER TABLE users MODIFY cpf VARBINARY(255);

-- Remover conta de teste
DROP USER 'test'@'localhost';

-- Restringir root
DELETE FROM mysql.user WHERE user='root' AND host='%';
FLUSH PRIVILEGES;

-- Ativar SSL
-- (adicionar em my.cnf: require_secure_transport=ON)</code></pre>
            </div>

        </div>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-terminal"></i> Comandos disponíveis</h2>
    <div class="beaver-card">
        <pre><code class="language-bash"># Análise completa (tudo)
php beaver dbscope:scan

# Por categoria
php beaver dbscope:tables
php beaver dbscope:indexes
php beaver dbscope:relations
php beaver dbscope:procedures
php beaver dbscope:triggers
php beaver dbscope:views
php beaver dbscope:events
php beaver dbscope:users
php beaver dbscope:performance
php beaver dbscope:security

# Filtrado por tabela
php beaver dbscope:scan --table=users

# Gerar relatório
php beaver dbscope:report html
php beaver dbscope:report json
php beaver dbscope:report markdown</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-folder-tree"></i> Estrutura recomendada</h2>
    <div class="beaver-card">
        <div class="folder-tree">beaver-framework/
└── src/
    └── Database/
        └── Scope/
            ├── DbScope.php               # orquestrador
            ├── Analyzers/
            │   ├── TablesAnalyzer.php
            │   ├── IndexesAnalyzer.php
            │   ├── RelationsAnalyzer.php
            │   ├── ProceduresAnalyzer.php
            │   ├── TriggersAnalyzer.php
            │   ├── ViewsAnalyzer.php
            │   ├── EventsAnalyzer.php
            │   ├── UsersAnalyzer.php
            │   ├── PerformanceAnalyzer.php
            │   └── SecurityAnalyzer.php
            └── Report/
                ├── HtmlReport.php
                ├── JsonReport.php
                └── ConsoleReport.php</div>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-vial"></i> Testar com Unity Test</h2>
    <div class="beaver-card">
        <pre><code class="language-php">use Beaver\Testing\UnityTest;
use Beaver\Database\Scope\DbScope;

UnityTest::describe('DbScope', function () {

    UnityTest::test('deteta tabelas sem PRIMARY KEY', function () {
        $scope = new DbScope($pdo, 'test_db');
        $report = $scope->scan(['indexes' => true]);

        UnityTest::assertTrue(
            count($report['indexes']['without_primary']) > 0,
            'Deve detetar pelo menos uma tabela sem PK'
        );
    });

    UnityTest::test('deteta índices duplicados', function () {
        $report = (new DbScope($pdo, 'test_db'))->scan(['indexes' => true]);

        UnityTest::assertContains(
            'users',
            array_column($report['indexes']['duplicates'], 'table')
        );
    });

});</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-flag-checkered"></i> Boas práticas</h2>
    <div class="beaver-card">
        <ul class="mb-0">
            <li>Toda a tabela deve ter <strong>PRIMARY KEY</strong>.</li>
            <li>Toda a <strong>foreign key</strong> deve ter índice.</li>
            <li>Evita <code class="inline-code">ON DELETE CASCADE</code> em dados sensíveis.</li>
            <li>Adiciona <strong>comentários</strong> em colunas e tabelas.</li>
            <li>Usa <code class="inline-code">utf8mb4</code> e <code class="inline-code">InnoDB</code> sempre.</li>
            <li>Corre <code class="inline-code">dbscope:scan</code> antes de cada deploy.</li>
            <li>Automatiza relatórios semanais para o email da equipa.</li>
        </ul>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
