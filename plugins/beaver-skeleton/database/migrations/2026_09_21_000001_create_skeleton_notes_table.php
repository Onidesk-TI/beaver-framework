<?php

declare(strict_types=1);

/**
 * Migration: skeleton_notes
 *
 * Exemplo de migration de plugin. Corre com:
 *   php beaver migrate
 */

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
