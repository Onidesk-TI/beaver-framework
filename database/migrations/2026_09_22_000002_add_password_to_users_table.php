<?php

declare(strict_types=1);

use Beaver\Database\Migrations\Migration;
use Beaver\Database\Migrations\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::raw("ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT ''");

        try {
            Schema::raw("ALTER TABLE users ADD UNIQUE KEY users_email_unique (email)");
        } catch (\Throwable) {}
    }

    public function down(): void
    {
        try { Schema::raw("ALTER TABLE users DROP INDEX users_email_unique"); } catch (\Throwable) {}
        try { Schema::raw("ALTER TABLE users DROP COLUMN password"); } catch (\Throwable) {}
    }
};
