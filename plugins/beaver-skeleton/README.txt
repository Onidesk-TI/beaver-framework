========================================================================
  BEAVER SKELETON
  Esqueleto oficial para criar plugins para o Beaver Framework
========================================================================

License : MIT
PHP     : >= 8.1
Type    : beaver-plugin
Repo    : https://github.com/Onidesk-TI/beaver-console

------------------------------------------------------------------------
  O QUE É
------------------------------------------------------------------------

Um plugin base pronto a clonar para criares o teu próprio plugin Beaver
em segundos. Traz:

  - Manifest (plugin.json)
  - Composer (type: beaver-plugin)
  - Classe principal (extends PluginBase)
  - Rotas com assets (/plugins/beaver-skeleton/css|js)
  - View de exemplo
  - CSS + JS no tema âmbar/castanho

------------------------------------------------------------------------
  INSTALAÇÃO RÁPIDA
------------------------------------------------------------------------

  # 1. Clonar para o teu plugin
  git clone https://github.com/Onidesk-TI/beaver-console.git meu-plugin
  cd meu-plugin

  # 2. Renomear (substituir "Skeleton" pelo teu nome)
  #    ver secção "Renomear" abaixo

  # 3. Instalar
  composer install

------------------------------------------------------------------------
  ESTRUTURA
------------------------------------------------------------------------

  beaver-skeleton/
  ├── plugin.json                # manifest do plugin
  ├── composer.json              # autoload + type: beaver-plugin
  ├── README.md
  ├── HELP.md
  ├── LICENSE
  ├── .gitignore
  ├── .editorconfig
  ├── routes/
  │   └── web.php                # rotas do plugin
  ├── src/
  │   └── SkeletonPlugin.php     # classe principal
  ├── resources/
  │   ├── views/
  │   │   └── index.php          # view de exemplo
  │   └── ui/
  │       ├── css/               # CSS
  │       └── js/                # JS
  └── tests/
      └── PluginTest.php

------------------------------------------------------------------------
  RENOMEAR PARA O TEU PLUGIN
------------------------------------------------------------------------

  Substitui em todos os ficheiros:

    De                              Para
    ------------------------------  ------------------------------
    Skeleton                        MeuPlugin
    skeleton                        meu-plugin
    Beaver\Plugins\Skeleton         Beaver\Plugins\MeuPlugin
    onidesk/beaver-skeleton         onidesk/beaver-meu-plugin

  Comando rápido (Linux/macOS):

    grep -rl "Skeleton" . | xargs sed -i 's/Skeleton/MeuPlugin/g'
    grep -rl "skeleton" . | xargs sed -i 's/skeleton/meu-plugin/g'

------------------------------------------------------------------------
  ASSETS
------------------------------------------------------------------------

  Os assets são servidos pelo router do plugin:

    URL                              Ficheiro
    -------------------------------  --------------------------------
    /plugins/beaver-skeleton/css/<file>     resources/ui/css/<file>
    /plugins/beaver-skeleton/js/<file>      resources/ui/js/<file>

------------------------------------------------------------------------
  TESTES
------------------------------------------------------------------------

  vendor/bin/phpunit

------------------------------------------------------------------------
  DOCUMENTAÇÃO
------------------------------------------------------------------------

  Vê o HELP.md para detalhes de desenvolvimento.

------------------------------------------------------------------------
  LICENÇA
------------------------------------------------------------------------

  MIT © Onidesk
========================================================================


========================================================================
  BASE DE DADOS — EXEMPLO COMPLETO
========================================================================

Este plugin demonstra como usar a base de dados num plugin Beaver.

Estrutura:

    database/migrations/2026_09_21_000001_create_skeleton_notes_table.php
    src/Models/Note.php
    src/Services/NoteService.php
    routes/web.php

------------------------------------------------------------------------
  1. MIGRATION
------------------------------------------------------------------------

    use Beaver\Database\Migrations\Migration;
    use Beaver\Database\Migrations\Schema;
    use Beaver\Database\Migrations\Blueprint;

    return new class extends Migration {
        public function up(): void
        {
            Schema::create('skeleton_notes', function (Blueprint $t) {
                $t->id();
                $t->string('title');
                $t->text('body')->nullable();
                $t->timestamps();
            });
        }

        public function down(): void
        {
            Schema::drop('skeleton_notes');
        }
    };

  Correr:  php beaver migrate
  Ver:     php beaver migrate:status

  NOTA: o comando `migrate` descobre automaticamente as migrations
  de cada plugin via PluginManager. Não é preciso registar nada.

------------------------------------------------------------------------
  2. MODEL
------------------------------------------------------------------------

    namespace Beaver\Plugins\Skeleton\Models;

    use Beaver\Database\Model\Model;

    class Note extends Model
    {
        // IMPORTANTE: $table é static no Model base
        protected static string $table = 'skeleton_notes';

        protected array $fillable = ['title', 'body'];
    }

------------------------------------------------------------------------
  3. SERVICE
------------------------------------------------------------------------

    namespace Beaver\Plugins\Skeleton\Services;

    use Beaver\Plugins\Skeleton\Models\Note;

    class NoteService
    {
        public function all(): array
        {
            return Note::query()->orderBy('id', 'desc')->get();
        }

        public function find(int $id): ?Note
        {
            return Note::find($id);
        }

        public function create(string $title, string $body = ''): Note
        {
            return Note::create(['title' => $title, 'body' => $body]);
        }

        public function delete(int $id): bool
        {
            $note = $this->find($id);
            return $note ? $note->delete() : false;
        }
    }

------------------------------------------------------------------------
  4. ROTAS REST
------------------------------------------------------------------------

    GET    /skeleton/notes          → lista todas
    POST   /skeleton/notes          → cria nova
    DELETE /skeleton/notes/{id}     → apaga

  Exemplo com curl:

    curl http://localhost/skeleton/notes
    curl -X POST http://localhost/skeleton/notes \
         -d "title=Minha nota&body=Conteudo"
    curl -X DELETE http://localhost/skeleton/notes/1

------------------------------------------------------------------------
  5. TESTE RÁPIDO (PHP CLI)
------------------------------------------------------------------------

    require 'vendor/autoload.php';

    use Beaver\Plugins\Skeleton\Services\NoteService;

    $svc = new NoteService();
    $n = $svc->create('Primeira', 'Ola Beaver');
    echo "Criada #{$n->id}\n";

    foreach ($svc->all() as $note) {
        echo "[{$note->id}] {$note->title}\n";
    }

------------------------------------------------------------------------
  6. API DO DATABASE (casos avançados)
------------------------------------------------------------------------

  O Service cobre o dia-a-dia. O Database está disponível para casos
  específicos:

    $db = \Beaver\Database\Database::getInstance();

    $db->select($sql, $params)      // todas as linhas
    $db->selectOne($sql, $params)   // uma linha ou null
    $db->insert($sql, $params)      // último ID
    $db->update($sql, $params)      // linhas afetadas
    $db->delete($sql, $params)      // linhas afetadas
    $db->exec($sql)                 // DDL (CREATE/ALTER/DROP)
    $db->query($sql)                // PDOStatement
    $db->tableExists($t)            // bool
    $db->getTableColumns($t)        // colunas
    $db->transaction(callable)      // wrapper de transação

  Exemplo:

    if ($db->tableExists('skeleton_notes')) {
        $n = $db->selectOne('SELECT COUNT(*) AS n FROM skeleton_notes');
        echo "Existem {$n['n']} notas\n";
    }

========================================================================