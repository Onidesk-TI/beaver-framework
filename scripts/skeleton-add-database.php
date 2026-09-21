<?php

declare(strict_types=1);

/**
 * Adiciona exemplo de BD ao beaver-skeleton (source).
 *
 * Target: /var/www/onidesk/beaver-skeleton
 *
 * Cria:
 *   - database/migrations/2026_09_21_000001_create_skeleton_notes_table.php
 *   - src/Models/Note.php
 *   - src/Services/NoteService.php
 *   - append em routes/web.php (se ainda não existirem)
 *   - append em SkeletonPlugin.php (loadMigrations, se faltar)
 */

$base = '/var/www/onidesk/beaver-skeleton';

if (!is_dir($base)) {
    fwrite(STDERR, "✗ Pasta não existe: $base\n");
    exit(1);
}

echo "==> Skeleton source: $base\n\n";

// ------------------------------------------------------------
// Pastas possíveis
// ------------------------------------------------------------
foreach (['database', 'database/migrations', 'src/Models', 'src/Services'] as $d) {
    $p = "$base/$d";
    if (!is_dir($p)) {
        @mkdir($p, 0775, true);
        echo "  + $d/\n";
    } else {
        echo "  ~ $d/ já existe\n";
    }
}

// ------------------------------------------------------------
//  Migration
// ------------------------------------------------------------
$migration = "$base/database/migrations/2026_09_21_000001_create_skeleton_notes_table.php";
if (!is_file($migration)) {
    file_put_contents($migration, <<<'PHPF'
<?php

declare(strict_types=1);

/**
 * Migration: skeleton_notes
 *
 * Exemplo de migration de plugin. Corre com:
 *   php beaver migrate
 */

return new class {
    public function up($db): void
    {
        $db->statement('
            CREATE TABLE IF NOT EXISTS skeleton_notes (
                id          INTEGER PRIMARY KEY AUTOINCREMENT,
                title       TEXT    NOT NULL,
                body        TEXT,
                created_at  TEXT    NOT NULL,
                updated_at  TEXT    NOT NULL
            )
        ');
    }

    public function down($db): void
    {
        $db->statement('DROP TABLE IF EXISTS skeleton_notes');
    }
};
PHPF);
    @chmod($migration, 0664);
    echo "  + database/migrations/...create_skeleton_notes_table.php\n";
} else {
    echo "  ~ migration já existe\n";
}

// ------------------------------------------------------------
//  Model
// ------------------------------------------------------------
$model = "$base/src/Models/Note.php";
if (!is_file($model)) {
    file_put_contents($model, <<<'PHPF'
<?php

declare(strict_types=1);

namespace Beaver\Plugins\BeaverSkeleton\Models;

use Beaver\Database\Model\Model;

/**
 * Exemplo de Model do plugin.
 *
 * @property int    $id
 * @property string $title
 * @property string $body
 */
class Note extends Model
{
    protected string $table = 'skeleton_notes';

    protected array $fillable = ['title', 'body'];
}
PHPF);
    @chmod($model, 0664);
    echo "  + src/Models/Note.php\n";
} else {
    echo "  ~ Note.php já existe\n";
}

// ------------------------------------------------------------
//  Service
// ------------------------------------------------------------
$service = "$base/src/Services/NoteService.php";
if (!is_file($service)) {
    file_put_contents($service, <<<'PHPF'
<?php

declare(strict_types=1);

namespace Beaver\Plugins\BeaverSkeleton\Services;

use Beaver\Plugins\BeaverSkeleton\Models\Note;

/**
 * Lógica de negócio para Notes.
 */
class NoteService
{
    /** @return Note[] */
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
        return Note::create([
            'title' => $title,
            'body'  => $body,
        ]);
    }

    public function delete(int $id): bool
    {
        $note = $this->find($id);
        return $note ? $note->delete() : false;
    }
}
PHPF);
    @chmod($service, 0664);
    echo "  + src/Services/NoteService.php\n";
} else {
    echo "  ~ NoteService.php já existe\n";
}

// ------------------------------------------------------------
//  Plugin class — append de loadMigrations() se faltar
// ------------------------------------------------------------
$pluginFile = "$base/src/SkeletonPlugin.php";
if (!is_file($pluginFile)) {
    // procura qualquer *Plugin.php
    foreach (glob("$base/src/*Plugin.php") as $f) {
        $pluginFile = $f;
        break;
    }
}

if (is_file($pluginFile)) {
    $src = file_get_contents($pluginFile);
    if (!str_contains($src, 'loadMigrations')) {
        $src = preg_replace(
            '/(\$this->loadRoutes\(\);\n)(\s*\})/',
            "$1        \$this->loadMigrations();\n$2",
            $src,
            1
        );
        file_put_contents($pluginFile, $src);
        echo "  + " . basename($pluginFile) . ": loadMigrations() adicionado\n";
    } else {
        echo "  ~ " . basename($pluginFile) . " já chama loadMigrations()\n";
    }
} else {
    echo "  ⚠ Plugin principal não encontrado\n";
}

// ------------------------------------------------------------
//  Rotas — append se faltar
// ------------------------------------------------------------
$routes = "$base/routes/web.php";
if (is_file($routes)) {
    $src = file_get_contents($routes);
    if (!str_contains($src, '/skeleton/notes')) {
        $extra = <<<'PHPF'

// ------------------------------------------------------------------
// Exemplo de BD — CRUD de Notes
// ------------------------------------------------------------------

$router->get('/skeleton/notes', function () {
    return \Beaver\Http\Response::json(
        (new \Beaver\Plugins\BeaverSkeleton\Services\NoteService())->all()
    );
});

$router->post('/skeleton/notes', function (\Beaver\Http\Request $req) {
    $note = (new \Beaver\Plugins\BeaverSkeleton\Services\NoteService())->create(
        (string) $req->input('title', 'sem título'),
        (string) $req->input('body', ''),
    );
    return \Beaver\Http\Response::json(['id' => $note->id], 201);
});

$router->delete('/skeleton/notes/{id}', function (int $id) {
    $ok = (new \Beaver\Plugins\BeaverSkeleton\Services\NoteService())->delete($id);
    return \Beaver\Http\Response::json(['deleted' => $ok]);
});
PHPF;
        file_put_contents($routes, $src . $extra);
        echo "  + routes/web.php: rotas /skeleton/notes adicionadas\n";
    } else {
        echo "  ~ routes/web.php já tem /skeleton/notes\n";
    }
} else {
    echo "  ⚠ routes/web.php não encontrado\n";
}

echo "\n✔ Pronto.\n";
