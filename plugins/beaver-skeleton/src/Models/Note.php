<?php

declare(strict_types=1);

namespace Beaver\Plugins\Skeleton\Models;

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
    protected static string $table = 'skeleton_notes';

    protected array $fillable = ['title', 'body'];
}
