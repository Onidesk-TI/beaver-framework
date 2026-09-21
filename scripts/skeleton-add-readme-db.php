<?php

declare(strict_types=1);

/**
 * Acrescenta secção "Base de dados" ao README do beaver-skeleton.
 * Aplica em: source + cópia plugins/.
 */

$files = [
    '/var/www/onidesk/beaver-skeleton/README.txt',
    '/var/www/onidesk/beaver-framework/plugins/beaver-skeleton/README.txt',
];

$section = <<<'TXT'


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
TXT;

foreach ($files as $file) {
    if (!is_file($file)) {
        echo "  ~ skip: $file\n";
        continue;
    }

    $src = file_get_contents($file);
    if (str_contains($src, 'BASE DE DADOS — EXEMPLO COMPLETO')) {
        echo "  ~ já tem: $file\n";
        continue;
    }

    file_put_contents($file, rtrim($src) . "\n" . $section);
    echo "  + atualizado: $file\n";
}

echo "\n✔ Pronto.\n";
