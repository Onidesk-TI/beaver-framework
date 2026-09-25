<?php
/**
 * commands.php — Beaver Framework
 * Guia completo: criar, registar e correr comandos CLI.
 */
declare(strict_types=1);

$PASSOS = [
    [
        'id'    => 'estrutura',
        'name'  => '1 · Estrutura da classe',
        'icon'  => 'code',
        'tags'  => ['cli', 'core', 'básico'],
        'desc'  => 'Todo comando herda de Beaver\Console\Command. Define signature (nome + args) e description. O método handle() devolve um código de saída.',
        'component' => <<<'PHP'
namespace Beaver\Console\Commands;

use Beaver\Console\Command;

class ExemploCommand extends Command
{
    // Nome do comando e argumentos no formato {nome} ou {--opcao=default}
    protected string $signature = 'exemplo:correr {arg1} {arg2?} {--flag} {--opt=valor}';

    // Descrição que aparece em `beaver help`
    protected string $description = 'Faz uma coisa de exemplo.';

    public function handle(): int
    {
        // Argumentos posicionais
        $arg1 = $this->argument('arg1');
        $arg2 = $this->argument('arg2', 'default');

        // Opções (--flag, --opt=xxx)
        $flag = (bool) $this->option('flag');
        $opt  = $this->option('opt');

        // Output com cores e símbolos
        $this->info('A processar...');
        $this->success('Feito!');
        $this->warning('Atenção com isto.');
        $this->error('Algo falhou.');

        // 0 = SUCCESS, 1 = FAILURE, 2 = INVALID
        return self::SUCCESS;
    }
}
PHP,
        'instance' => <<<'PHP'
// Helpers disponíveis dentro do comando:

$this->info('…');        // › ciano
$this->success('…');     // ✓ verde
$this->warning('…');     // ! amarelo
$this->error('…');       // ✗ vermelho
$this->line('…');        // linha simples
$this->line();           // linha vazia

// Ler argumentos
$valor = $this->argument('nome', $default);

// Ler opções
$flag  = (bool) $this->option('flag');
$valor = $this->option('opt', $default);

// Caminho do projeto (para localizar plugins/, storage/, etc.)
$raiz = $this->projectPath;

// Perguntar ao utilizador (interativo)
$sim   = $this->confirm('Tens a certeza?', false);
$texto = $this->ask('Como te chamas?', 'Anónimo');
PHP,
        'example' => <<<'PHP'
// Comando real: plugin:list
class PluginListCommand extends Command
{
    protected string $signature = 'plugin:list {--json}';
    protected string $description = 'Lista todos os plugins descobertos';

    public function handle(): int
    {
        $rows = PluginPaths::manifests('prod', []);

        if ($this->option('json')) {
            echo json_encode($rows, JSON_PRETTY_PRINT);
            return self::SUCCESS;
        }

        foreach ($rows as $r) {
            $this->line("  ▸ {$r['slug']}  ({$r['path']})");
        }

        $this->success(count($rows) . ' plugin(s)');
        return self::SUCCESS;
    }
}
PHP,
    ],
    [
        'id'    => 'registo',
        'name'  => '2 · Registo (auto-descoberta)',
        'icon'  => 'route',
        'tags'  => ['cli', 'core', 'registo'],
        'desc'  => 'O Beaver descobre comandos automaticamente por glob. Basta o ficheiro estar em src/Console/Commands/*Command.php com o namespace certo — não há registo manual.',
        'component' => <<<'PHP'
// Como o Application descobre comandos (simplificado):

protected function registerFrameworkCommands(): void
{
    $dir = $this->frameworkPath . '/src/Console/Commands';

    foreach (glob($dir . '/*Command.php') as $file) {
        $class = 'Beaver\\Console\\Commands\\' . basename($file, '.php');

        if (!class_exists($class)) continue;

        $instance = new $class();
        $this->commands[$instance->name()] = $class;
    }
}
PHP,
        'instance' => <<<'PHP'
// Convenções (o que o auto-load espera):

// 1) LOCALIZAÇÃO
//    src/Console/Commands/NomeCommand.php
//    └─ sem subpastas — o glob não desce

// 2) NAMESPACE
//    namespace Beaver\Console\Commands;

// 3) CLASSE
//    class NomeCommand extends Command
//    └─ tem de terminar em "Command"

// 4) SIGNATURE
//    protected string $signature = 'nome:acao';

// 5) NOME DO FICHEIRO = NOME DA CLASSE
//    CursosSyncCommand.php  →  class CursosSyncCommand
//    comandos:sync          →  CursosSyncCommand
PHP,
        'example' => <<<'BASH'
# Fluxo típico após criar o ficheiro:

# 1) Recarregar o autoload do Composer
composer dump-autoload -d /var/www/onidesk/beaver-framework

# 2) Confirmar que aparece na lista
./beaver help | grep <nome-do-comando>

# 3) Correr
./beaver <nome-do-comando>

# Se NÃO aparecer:
#   ✗ namespace errado
#   ✗ classe não termina em Command
#   ✗ nome do ficheiro ≠ nome da classe
#   ✗ esqueceu o composer dump-autoload
BASH,
    ],
    [
        'id'    => 'boot',
        'name'  => '3 · Boot do framework',
        'icon'  => 'zap',
        'tags'  => ['cli', 'core', 'bootstrap'],
        'desc'  => 'Se o comando precisa de BD, plugins carregados, config ou rotas, chama $app->boot() antes de usar. Sem boot, o Container não está pronto e os modelos não funcionam.',
        'component' => <<<'PHP'
use Beaver\Foundation\Application;

public function handle(): int
{
    $app = Application::getInstance();
    $app->boot();   // ← carrega config, plugins, rotas, container

    // Agora sim: BD, modelos e plugins estão disponíveis
    $cursos = \Beaver\Plugins\Cursos\Models\Curso::all();

    return self::SUCCESS;
}
PHP,
        'instance' => <<<'PHP'
// Cuidado: o boot carrega TODOS os plugins e imprime logs.
// Para comandos limpos, podes suprimir com ob_start():

$app = Application::getInstance();

ob_start();      // captura tudo o que os plugins escrevem
$app->boot();
ob_end_clean();  // descarta

// A partir daqui, output limpo
$this->success('Boot silencioso OK');
PHP,
        'example' => <<<'PHP'
// Exemplo real — CursosSyncCommand
class CursosSyncCommand extends Command
{
    protected string $signature = 'cursos:sync {--dir=} {--quiet}';
    protected string $description = 'Sincroniza packs de curso com a BD';

    public function handle(): int
    {
        $app = Application::getInstance();
        $app->boot();    // ← precisa dos modelos de curso

        $dirs = $this->option('dir')
            ? [(string) $this->option('dir')]
            : [$this->projectPath . '/plugins'];

        $loader = new CourseLoader($dirs);
        $report = $loader->syncAll();

        if (!$this->option('quiet')) {
            $this->success("Sincronizados: {$report['ok']} curso(s)");
        }

        return empty($report['erros']) ? self::SUCCESS : self::FAILURE;
    }
}
PHP,
    ],
    [
        'id'    => 'debug',
        'name'  => '4 · Testar e depurar',
        'icon'  => 'search-db',
        'tags'  => ['cli', 'devtools', 'testes'],
        'desc'  => 'Antes de correr via ./beaver, testa a sintaxe, confirma a descoberta, vê a lista real e usa o --json para automação. Diagnóstico rápido em 4 comandos.',
        'component' => <<<'BASH'
# Diagnóstico em 4 passos

# 1) Sintaxe da classe
php -l src/Console/Commands/MeuCommand.php
# → "No syntax errors detected"

# 2) Autoload atualizado
composer dump-autoload -d /var/www/onidesk/beaver-framework

# 3) Descoberta
./beaver help | grep meu:
# → "  meu:comando    Descrição…"

# 4) Execução
./beaver meu:comando --dry-run
BASH,
        'instance' => <<<'BASH'
# Quando NÃO aparece no help:

# a) Ficheiro no sítio errado?
ls -la src/Console/Commands/MeuCommand.php

# b) Namespace errado?
head -10 src/Console/Commands/MeuCommand.php | grep namespace
# deve ser: namespace Beaver\Console\Commands;

# c) Classe com o nome errado?
grep "^class " src/Console/Commands/MeuCommand.php
# deve ser: class MeuCommand extends Command

# d) Autoload desatualizado?
composer dump-autoload -d /var/www/onidesk/beaver-framework

# e) Syntax errors a impedir o carregamento?
php -l src/Console/Commands/MeuCommand.php
BASH,
        'example' => <<<'BASH'
# Fluxo de teste completo, do zero ao primeiro run:

# 1) Criar o ficheiro
cat > src/Console/Commands/OlaCommand.php << 'PHP'
<?php
namespace Beaver\Console\Commands;
use Beaver\Console\Command;
class OlaCommand extends Command
{
    protected string $signature = 'ola {nome=beaver}';
    protected string $description = 'Diz olá';
    public function handle(): int
    {
        $this->success("Olá, {$this->argument('nome')}!");
        return self::SUCCESS;
    }
}
PHP

# 2) Autoload
composer dump-autoload -d /var/www/onidesk/beaver-framework

# 3) Confirmar
./beaver help | grep ola

# 4) Correr
./beaver ola
# → ✓ Olá, beaver!

./beaver ola --nome=Franco
# → ✓ Olá, Franco!
BASH,
    ],
    [
        'id'    => 'sync-integrado',
        'name'  => '5 · Integrar com plugin:sync',
        'icon'  => 'layers',
        'tags'  => ['cli', 'plugins', 'avançado'],
        'desc'  => 'Se o comando pertence a um plugin, o plugin:sync chama-o automaticamente. Basta nomeá-lo <slug>:sync — o plugin:sync descobre-o na lista real de comandos.',
        'component' => <<<'PHP'
// Convenção de nomes para integração automática:

// Plugin "beaver-cursos"  →  comando "cursos:sync"
// Plugin "blog"           →  comando "blog:sync"
// Plugin "beaver-admin"   →  comando "admin:sync"

// O plugin:sync remove o prefixo "beaver-" e procura <resto>:sync
// na lista de comandos registados. Se encontrar, corre-o.

class PluginSyncCommand extends Command
{
    private function descobrirSyncEspecifico(string $slug): ?string
    {
        $comandos = Application::getInstance()->commands();
        $nomeCurto = preg_replace('/^beaver-/', '', $slug);

        foreach (["{$nomeCurto}:sync", "{$slug}:sync"] as $cmd) {
            if (isset($comandos[$cmd])) return $cmd;
        }
        return null;
    }
}
PHP,
        'instance' => <<<'BASH'
# Resultado no terminal:

$ ./beaver plugin:sync beaver-cursos

 › 🦫  Beaver — Plugin Sync

  ▸ beaver-cursos
    ✓ migrations registadas
    ✓ autoload

 › 🦫  Beaver Cursos — Sync      ← comandos:sync a correr
  Procurando packs em: .../plugins

 ✓ Sincronizados: 1 curso(s)

 ✓ Sincronizados: 1/1 plugin(s)
BASH,
        'example' => <<<'PHP'
// Para criar o teu comando de sync de plugin:

// 1) Escolhe o nome: "<slug-curto>:sync"
//    beaver-cursos  →  cursos:sync
//    beaver-admin   →  admin:sync

// 2) Cria em src/Console/Commands/<Nome>SyncCommand.php
//    Se for do plugin, o ficheiro pode ficar em:
//      beaver-framework/src/Console/Commands/
//    Ou dentro do próprio plugin (se o plugin expõe os seus comandos)

// 3) O plugin:sync deteta-o automaticamente e chama-o
//    quando o plugin correspondente é sincronizado.
PHP,
    ],
];

$perPage   = 3;
$page      = max(1, (int)($_GET['page'] ?? 1));
$total     = count($PASSOS);
$pages     = max(1, (int)ceil($total / $perPage));
$page      = min($page, $pages);
$offset    = ($page - 1) * $perPage;
$pageItems = array_slice($PASSOS, $offset, $perPage);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Comandos — Beaver Framework 🦫</title>
<meta name="description" content="Guia completo: criar, registar e correr comandos no Beaver Framework.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  /* ── mesmo design system da documentation.php ── */
  *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
  :root{
    --amber:#F5A623;--amber-2:#E07800;--amber-3:#FFC46B;--amber-4:#FFE0A6;--amber-deep:#8A4A00;
    --gray-50:#FAFAFA;--gray-100:#F4F5F7;--gray-200:#EAECEF;--gray-300:#D9DCE1;--gray-400:#B8BDC4;
    --gray-500:#8A9099;--gray-600:#5F656D;--gray-700:#3F444B;
    --bg:#F4F5F7;--card:#FFFFFF;--card-2:#FAFAFA;
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
  .brand-logo{width:42px;height:42px;border-radius:13px;flex:none;background:linear-gradient(150deg,var(--amber-4),var(--amber-3) 55%,var(--amber));border:1.5px solid rgba(138,74,0,.35);display:grid;place-items:center;box-shadow:0 8px 20px -10px rgba(224,120,0,.6), inset 0 1px 0 rgba(255,255,255,.7);transition:transform .3s}
  .brand:hover .brand-logo{transform:rotate(-8deg) scale(1.06)}
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
  .nav-cta:hover{transform:translateY(-1px);box-shadow:0 14px 26px -12px rgba(224,120,0,1), inset 0 1px 0 rgba(255,255,255,.6)}
  .nav-cta svg{width:15px;height:15px;stroke:#fff;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}

  .hero{max-width:1240px;margin:0 auto;padding:44px 24px 8px;width:100%}
  .hero h1{font-size:clamp(1.6rem,3vw,2.2rem);letter-spacing:-.035em;font-weight:800;color:#2B2F36;margin-bottom:8px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
  .hero h1 .badge{font-family:'JetBrains Mono',monospace;font-size:.7rem;font-weight:700;padding:5px 10px;border-radius:100px;background:rgba(245,166,35,.18);color:var(--amber-deep);border:1px solid rgba(224,120,0,.28);letter-spacing:.02em;text-transform:uppercase}
  .hero p{color:var(--text-soft);max-width:720px;font-size:.98rem}

  .filters-wrap{max-width:1240px;margin:0 auto;padding:20px 24px 0;width:100%;position:sticky;top:72px;z-index:40}
  .filters{background:rgba(255,255,255,.92);backdrop-filter:blur(16px) saturate(150%);-webkit-backdrop-filter:blur(16px) saturate(150%);border:1px solid var(--line);border-radius:16px;padding:12px;display:flex;align-items:center;gap:10px;box-shadow:0 12px 30px -18px rgba(60,60,70,.35), inset 0 1px 0 rgba(255,255,255,.9);flex-wrap:wrap}
  .search{flex:1;min-width:220px;display:flex;align-items:center;gap:10px;padding:0 14px;background:var(--gray-50);border:1.5px solid var(--gray-200);border-radius:11px;transition:all .2s;height:44px}
  .search:focus-within{border-color:var(--amber);background:#fff;box-shadow:0 0 0 4px rgba(245,166,35,.18)}
  .search svg{width:17px;height:17px;flex:none;stroke:var(--gray-500);fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
  .search input{border:0;outline:0;background:transparent;font-family:inherit;font-size:.92rem;color:var(--text);width:100%;font-weight:500}
  .search input::placeholder{color:var(--gray-400)}
  .filter-tags{display:flex;gap:6px;flex-wrap:wrap}
  .tag-btn{border:1.5px solid var(--gray-200);background:#fff;color:var(--gray-600);padding:8px 13px;border-radius:100px;font-size:.78rem;font-weight:700;cursor:pointer;transition:all .2s;font-family:inherit;letter-spacing:.01em}
  .tag-btn:hover{border-color:var(--amber-3);color:var(--amber-deep);background:rgba(245,166,35,.06)}
  .tag-btn.active{background:linear-gradient(150deg,var(--amber-3),var(--amber));border-color:rgba(138,74,0,.35);color:#fff;text-shadow:0 1px 2px rgba(120,60,0,.3);box-shadow:0 6px 14px -8px rgba(224,120,0,.85)}
  .filter-count{font-family:'JetBrains Mono',monospace;font-size:.75rem;color:var(--muted);font-weight:600;padding:0 8px;white-space:nowrap}
  .filter-count b{color:var(--amber-2);font-weight:800}

  .list{max-width:1240px;margin:0 auto;padding:24px 24px 32px;width:100%;display:flex;flex-direction:column;gap:16px}
  .card{background:var(--card);border:1px solid var(--line);border-radius:18px;overflow:hidden;box-shadow:0 10px 24px -18px rgba(60,60,70,.35);transition:border-color .2s, box-shadow .2s, transform .2s;animation:cardIn .35s ease both}
  @keyframes cardIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
  .card:hover{border-color:rgba(224,120,0,.32);box-shadow:0 16px 34px -22px rgba(224,120,0,.55)}
  .card-head{display:flex;align-items:flex-start;gap:16px;padding:20px 22px;border-bottom:1px solid var(--line);background:linear-gradient(180deg,#FFFFFF, #FDFAF3)}
  .card-ico{width:48px;height:48px;border-radius:12px;flex:none;display:grid;place-items:center;background:linear-gradient(140deg,var(--amber-4),var(--amber-3));border:1px solid rgba(138,74,0,.28);box-shadow:inset 0 1px 0 rgba(255,255,255,.7)}
  .card-ico svg{width:24px;height:24px;stroke:var(--amber-deep);fill:none;stroke-width:1.9;stroke-linecap:round;stroke-linejoin:round}
  .card-info{flex:1;min-width:0}
  .card-title-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px}
  .card-title{font-size:1.12rem;font-weight:800;letter-spacing:-.02em;color:#2B2F36}
  .card-id{font-family:'JetBrains Mono',monospace;font-size:.7rem;color:var(--amber-deep);background:rgba(245,166,35,.16);padding:3px 8px;border-radius:6px;border:1px solid rgba(224,120,0,.22);font-weight:600}
  .card-desc{color:var(--text-soft);font-size:.9rem}
  .card-tags{display:flex;gap:6px;flex-wrap:wrap;margin-top:10px}
  .card-tags .t{font-family:'JetBrains Mono',monospace;font-size:.68rem;font-weight:600;color:var(--gray-600);background:var(--gray-100);border:1px solid var(--gray-200);padding:2px 8px;border-radius:6px;letter-spacing:.01em}

  .tabs{display:flex;background:#FBF9F4;border-bottom:1px solid var(--line);padding:0 12px;gap:2px;overflow-x:auto;scrollbar-width:none}
  .tabs::-webkit-scrollbar{display:none}
  .tab{position:relative;border:0;background:transparent;font-family:inherit;font-size:.83rem;font-weight:700;color:var(--gray-500);padding:12px 16px;cursor:pointer;letter-spacing:.01em;transition:color .18s;white-space:nowrap;display:inline-flex;align-items:center;gap:7px}
  .tab:hover{color:var(--amber-deep)}
  .tab.active{color:var(--amber-2)}
  .tab.active::after{content:"";position:absolute;left:12px;right:12px;bottom:-1px;height:2.5px;background:linear-gradient(90deg,var(--amber-3),var(--amber-2));border-radius:3px 3px 0 0}
  .tab svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}

  .panes{background:var(--code-bg);position:relative;overflow:hidden}
  .pane{display:none;padding:18px 22px 20px;animation:paneIn .25s ease both}
  .pane.active{display:block}
  @keyframes paneIn{from{opacity:0;transform:translateY(3px)}to{opacity:1;transform:none}}

  .code-block{position:relative;background:#FFFFFF;border:1px solid var(--line-strong);border-radius:12px;overflow:hidden}
  .code-head{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:linear-gradient(180deg,#FBF9F4,#F6F3EC);border-bottom:1px solid var(--line);font-family:'JetBrains Mono',monospace;font-size:.68rem;font-weight:700;color:var(--amber-deep);letter-spacing:.06em;text-transform:uppercase}
  .code-lang{display:inline-flex;align-items:center;gap:7px}
  .code-lang i{width:7px;height:7px;border-radius:50%;background:var(--amber);display:block;box-shadow:0 0 8px rgba(245,166,35,.9)}
  .copy-btn{border:1px solid var(--line-strong);background:#fff;color:var(--gray-600);font-family:inherit;font-size:.68rem;font-weight:700;padding:4px 9px;border-radius:6px;cursor:pointer;letter-spacing:.04em;transition:all .18s;display:inline-flex;align-items:center;gap:5px}
  .copy-btn:hover{color:var(--amber-deep);border-color:rgba(224,120,0,.4);background:rgba(245,166,35,.08)}
  .copy-btn.ok{color:#fff;background:var(--ok);border-color:var(--ok)}
  .copy-btn svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.4;stroke-linecap:round;stroke-linejoin:round}
  pre{margin:0;padding:14px 16px;overflow-x:auto;font-family:'JetBrains Mono',monospace;font-size:.78rem;line-height:1.7;color:var(--code-text);background:#FFFFFF;font-weight:500}
  pre::-webkit-scrollbar{height:8px}
  pre::-webkit-scrollbar-thumb{background:var(--gray-300);border-radius:4px}

  .pagination{max-width:1240px;margin:8px auto 40px;padding:0 24px;width:100%;display:flex;justify-content:center;align-items:center;gap:6px;flex-wrap:wrap}
  .page-btn,.page-num{min-width:40px;height:40px;padding:0 12px;border-radius:10px;border:1.5px solid var(--line-strong);background:#fff;color:var(--gray-600);font-family:inherit;font-size:.85rem;font-weight:700;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .18s}
  .page-btn:hover:not(:disabled),.page-num:hover{color:var(--amber-deep);border-color:rgba(224,120,0,.45);background:rgba(245,166,35,.08)}
  .page-num.active{background:linear-gradient(150deg,var(--amber-3),var(--amber));border-color:rgba(138,74,0,.35);color:#fff;text-shadow:0 1px 2px rgba(120,60,0,.3);box-shadow:0 8px 18px -10px rgba(224,120,0,.9)}
  .page-btn:disabled{opacity:.4;cursor:not-allowed}
  .page-btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.6;stroke-linecap:round;stroke-linejoin:round}

  .empty{display:none;text-align:center;padding:60px 24px;color:var(--muted)}
  .empty.show{display:block}
  .empty .ico{width:64px;height:64px;margin:0 auto 14px;border-radius:20px;background:rgba(245,166,35,.14);border:1px solid rgba(224,120,0,.22);display:grid;place-items:center}
  .empty .ico svg{width:32px;height:32px;stroke:var(--amber-2);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
  .empty strong{display:block;color:var(--text-soft);font-size:1rem;font-weight:700;margin-bottom:4px}

  footer{border-top:1px solid var(--line);background:rgba(250,250,252,.75);padding:22px 24px;text-align:center;font-size:.82rem;color:var(--text-soft);font-weight:500}
  footer .accent{color:var(--amber-2);font-weight:800}

  @media(max-width:980px){.nav-inner{padding:0 18px}.hero,.filters-wrap,.list,.pagination{padding-left:18px;padding-right:18px}.filters-wrap{top:72px}}
  @media(max-width:720px){.nav-links .nav-link span{display:none}.nav-link{padding:9px}.brand-name{font-size:1.05rem}.hero{padding-top:32px}.filters{gap:8px}.search{min-width:100%}.filter-tags{width:100%;overflow-x:auto;padding-bottom:2px;flex-wrap:nowrap}.filter-tags::-webkit-scrollbar{display:none}.tag-btn{flex-shrink:0}.card-head{padding:16px 16px;gap:12px}.card-ico{width:40px;height:40px;border-radius:10px}.card-ico svg{width:20px;height:20px}.card-title{font-size:1rem}.pane{padding:14px 14px 16px}.tabs{padding:0 6px}.tab{padding:11px 12px;font-size:.78rem}pre{font-size:.72rem;padding:12px}}
  @media(prefers-reduced-motion:reduce){*,*::before,*::after{animation-duration:.001ms !important;animation-iteration-count:1 !important;transition-duration:.001ms !important}}
  :focus-visible{outline:3px solid var(--amber-2);outline-offset:2px;border-radius:6px}
</style>
</head>
<body>

<!-- Sprite de ícones -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <linearGradient id="bvg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#FFE7BE"/>
      <stop offset="48%" stop-color="#F5A623"/>
      <stop offset="100%" stop-color="#E07800"/>
    </linearGradient>
    <symbol id="beaver" viewBox="0 0 64 64">
      <circle cx="13" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <circle cx="51" cy="17.5" r="7.5" fill="url(#bvg)"/>
      <ellipse cx="32" cy="33" rx="23" ry="21" fill="url(#bvg)"/>
      <ellipse cx="32" cy="41" rx="15.5" ry="12" fill="#8A4A00" opacity=".28"/>
      <ellipse cx="32" cy="34.5" rx="4.6" ry="3.2" fill="#2B1606"/>
      <circle cx="22.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="41.5" cy="26" r="3.4" fill="#2B1606"/>
      <circle cx="23.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <circle cx="42.6" cy="25" r="1.2" fill="#FFFCF6"/>
      <rect x="27.3" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
      <rect x="32.4" y="44.5" width="4.3" height="10.5" rx="1.7" fill="#FFFCF6"/>
    </symbol>
    <symbol id="ico-home" viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/></symbol>
    <symbol id="ico-book" viewBox="0 0 24 24"><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 0 4 22.5V4.5z"/><path d="M4 4.5A2.5 2.5 0 0 0 6.5 7H20"/></symbol>
    <symbol id="ico-terminal" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9l3 3-3 3"/><path d="M13 15h4"/></symbol>
    <symbol id="ico-gh" viewBox="0 0 24 24"><path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/></symbol>
    <symbol id="ico-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></symbol>
    <symbol id="ico-code" viewBox="0 0 24 24"><path d="M9 18l-6-6 6-6"/><path d="M15 6l6 6-6 6"/></symbol>
    <symbol id="ico-route" viewBox="0 0 24 24"><circle cx="6" cy="19" r="2.5"/><circle cx="18" cy="5" r="2.5"/><path d="M8.5 19h5a4 4 0 0 0 0-8h-3a4 4 0 0 1 0-8"/></symbol>
    <symbol id="ico-zap" viewBox="0 0 24 24"><path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/></symbol>
    <symbol id="ico-search-db" viewBox="0 0 24 24"><ellipse cx="11" cy="6" rx="7" ry="3"/><path d="M4 6v6c0 1.5 3.1 2.7 7 2.7"/><path d="M20 20l-3-3"/><circle cx="16" cy="15" r="3"/></symbol>
    <symbol id="ico-layers" viewBox="0 0 24 24"><path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M3 13l9 5 9-5"/></symbol>
    <symbol id="ico-check" viewBox="0 0 24 24"><path d="M5 13l4 4 10-10"/></symbol>
    <symbol id="ico-copy" viewBox="0 0 24 24"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></symbol>
    <symbol id="ico-chev-l" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></symbol>
    <symbol id="ico-chev-r" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></symbol>
  </defs>
</svg>

<?php
$active  = 'commands';
$version = $version ?? beaver_version();
require __DIR__ . '/partials/header-docs.php';
?>

<section class="hero">
  <h1>
    Comandos
    <span class="badge">CLI · <?= date('Y') ?></span>
  </h1>
  <p>
    Guia completo do ciclo de vida de um comando no Beaver: <strong>estrutura da classe</strong>,
    <strong>registo automático</strong>, <strong>boot do framework</strong>,
    <strong>testes e depuração</strong> e <strong>integração com <code>plugin:sync</code></strong>.
  </p>
</section>

<div class="filters-wrap">
  <div class="filters" role="search">
    <label class="search">
      <svg><use href="#ico-search"/></svg>
      <input id="q" type="search" placeholder="Pesquisar passo, tag ou descrição…" autocomplete="off">
    </label>

    <div class="filter-tags" id="tags" role="group">
      <button class="tag-btn active" data-tag="all" type="button">Tudo</button>
      <button class="tag-btn" data-tag="básico" type="button">Básico</button>
      <button class="tag-btn" data-tag="registo" type="button">Registo</button>
      <button class="tag-btn" data-tag="bootstrap" type="button">Bootstrap</button>
      <button class="tag-btn" data-tag="testes" type="button">Testes</button>
      <button class="tag-btn" data-tag="plugins" type="button">Plugins</button>
      <button class="tag-btn" data-tag="avançado" type="button">Avançado</button>
    </div>

    <span class="filter-count" id="count"><b><?= $total ?></b> passos</span>
  </div>
</div>

<section class="list" id="list">
  <?php foreach ($pageItems as $i => $c): ?>
  <article class="card"
    data-id="<?= htmlspecialchars($c['id']) ?>"
    data-tags="<?= htmlspecialchars(implode(' ', $c['tags'])) ?>"
    data-name="<?= htmlspecialchars($c['name']) ?>"
    data-desc="<?= htmlspecialchars($c['desc']) ?>"
    style="animation-delay:<?= $i * 40 ?>ms">
    <header class="card-head">
      <span class="card-ico" aria-hidden="true"><svg><use href="#ico-<?= htmlspecialchars($c['icon']) ?>"/></svg></span>
      <div class="card-info">
        <div class="card-title-row">
          <h2 class="card-title"><?= htmlspecialchars($c['name']) ?></h2>
          <span class="card-id"><?= htmlspecialchars($c['id']) ?></span>
        </div>
        <p class="card-desc"><?= htmlspecialchars($c['desc']) ?></p>
        <div class="card-tags">
          <?php foreach ($c['tags'] as $t): ?>
            <span class="t"><?= htmlspecialchars($t) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </header>

    <div class="tabs" role="tablist">
      <button class="tab active" role="tab" aria-selected="true" data-pane="component" type="button"><svg><use href="#ico-code"/></svg> Código</button>
      <button class="tab" role="tab" aria-selected="false" data-pane="instance" type="button"><svg><use href="#ico-layers"/></svg> Referência</button>
      <button class="tab" role="tab" aria-selected="false" data-pane="example" type="button"><svg><use href="#ico-check"/></svg> Exemplo</button>
    </div>

    <div class="panes">
      <div class="pane active" data-pane="component" role="tabpanel">
        <div class="code-block">
          <div class="code-head"><span class="code-lang"><i></i> PHP · código</span><button class="copy-btn" type="button" data-copy><svg><use href="#ico-copy"/></svg> copiar</button></div>
          <pre><?= htmlspecialchars(trim($c['component'])) ?></pre>
        </div>
      </div>
      <div class="pane" data-pane="instance" role="tabpanel">
        <div class="code-block">
          <div class="code-head"><span class="code-lang"><i></i> Referência</span><button class="copy-btn" type="button" data-copy><svg><use href="#ico-copy"/></svg> copiar</button></div>
          <pre><?= htmlspecialchars(trim($c['instance'])) ?></pre>
        </div>
      </div>
      <div class="pane" data-pane="example" role="tabpanel">
        <div class="code-block">
          <div class="code-head"><span class="code-lang"><i></i> Exemplo</span><button class="copy-btn" type="button" data-copy><svg><use href="#ico-copy"/></svg> copiar</button></div>
          <pre><?= htmlspecialchars(trim($c['example'])) ?></pre>
        </div>
      </div>
    </div>
  </article>
  <?php endforeach; ?>

  <div class="empty" id="empty">
    <div class="ico"><svg><use href="#ico-search"/></svg></div>
    <strong>Sem resultados</strong>
    <span>Tenta outro termo ou remove os filtros ativos.</span>
  </div>
</section>

<?php if ($pages > 1): ?>
<nav class="pagination">
  <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>" href="?page=<?= max(1, $page - 1) ?>" <?= $page <= 1 ? 'tabindex="-1"' : '' ?>><svg><use href="#ico-chev-l"/></svg></a>
  <?php for ($p = 1; $p <= $pages; $p++): ?>
    <a class="page-num <?= $p === $page ? 'active' : '' ?>" href="?page=<?= $p ?>"><?= $p ?></a>
  <?php endfor; ?>
  <a class="page-btn <?= $page >= $pages ? 'disabled' : '' ?>" href="?page=<?= min($pages, $page + 1) ?>" <?= $page >= $pages ? 'tabindex="-1"' : '' ?>><svg><use href="#ico-chev-r"/></svg></a>
</nav>
<?php endif; ?>

<footer>
  © <span id="ano"></span> Beaver Framework · Feito com <span class="accent">🦫</span> em Portugal
</footer>

<script>
/* Tabs */
document.querySelectorAll('.card').forEach(card => {
  const tabs  = card.querySelectorAll('.tab');
  const panes = card.querySelectorAll('.pane');
  tabs.forEach(tab => tab.addEventListener('click', () => {
    const target = tab.dataset.pane;
    tabs.forEach(t => { const on = t === tab; t.classList.toggle('active', on); t.setAttribute('aria-selected', on ? 'true' : 'false'); });
    panes.forEach(p => p.classList.toggle('active', p.dataset.pane === target));
  }));
});

/* Copiar */
document.querySelectorAll('[data-copy]').forEach(btn => {
  btn.addEventListener('click', async () => {
    const pre = btn.closest('.code-block').querySelector('pre');
    try {
      await navigator.clipboard.writeText(pre.textContent);
      const old = btn.innerHTML;
      btn.classList.add('ok');
      btn.innerHTML = '<svg><use href="#ico-check"/></svg> copiado';
      setTimeout(() => { btn.classList.remove('ok'); btn.innerHTML = old; }, 1400);
    } catch {}
  });
});

/* Filtro */
const q = document.getElementById('q');
const tagsWrap = document.getElementById('tags');
const empty = document.getElementById('empty');
const count = document.getElementById('count');
const cards = Array.from(document.querySelectorAll('.card'));
let activeTag = 'all';

const normalize = s => (s || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

function applyFilters() {
  const term = normalize(q.value.trim());
  let visible = 0;
  cards.forEach(card => {
    const hay = normalize(card.dataset.name + ' ' + card.dataset.desc + ' ' + card.dataset.tags + ' ' + card.dataset.id);
    const tags = card.dataset.tags.split(/\s+/);
    const show = (!term || hay.includes(term)) && (activeTag === 'all' || tags.includes(activeTag));
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  empty.classList.toggle('show', visible === 0);
  count.innerHTML = `<b>${visible}</b> passo${visible === 1 ? '' : 's'}`;
}

q.addEventListener('input', applyFilters);
tagsWrap.addEventListener('click', e => {
  const btn = e.target.closest('.tag-btn');
  if (!btn) return;
  tagsWrap.querySelectorAll('.tag-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  activeTag = btn.dataset.tag;
  applyFilters();
});

document.getElementById('ano').textContent = new Date().getFullYear();
</script>
</body>
</html>
