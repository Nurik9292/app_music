<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS albums CASCADE");
        // DB::connection('pgsql_prod')->statement("DROP TYPE IF EXISTS album_type");
        // DB::connection('pgsql_prod')->statement("CREATE TYPE album_type AS ENUM('album', 'single', 'soundtrack', 'live', 'remix')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TYPE album_type CASCADE");
    }
};
