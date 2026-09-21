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

use Beaver\Database\Migrations\Migration;
use Beaver\Database\Migrations\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', [
            'id',
            'name:str',
            'email:str',
            'age:int?',
            'is_active:bool=1',
            'timestamps',
        ]);
    }

    public function down(): void
    {
        Schema::drop('users');
    }
};