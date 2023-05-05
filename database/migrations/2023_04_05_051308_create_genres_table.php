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
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS genres CASCADE");
        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE genres (
        //     id serial PRIMARY KEY,
        //     name_tm VARCHAR(50) NOT NULL,
        //     name_ru VARCHAR(50) NOT NULL,
        //     parent_id integer DEFAULT 0
        //   );");

        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_genre_name_tk ON genres (name_tm);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_genre_name_ru ON genres (name_ru);");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE genres CASCADE");
    }
};
