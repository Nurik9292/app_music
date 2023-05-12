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
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS artists CASCADE");
        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE artists (
        //     id serial PRIMARY KEY,
        //     name VARCHAR(255) NOT NULL,
        //     added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     bio_tk TEXT DEFAULT '',
        //     bio_ru TEXT DEFAULT '',
        //     artwork_url VARCHAR(255) DEFAULT '',
        //     thumb_url VARCHAR(255) DEFAULT '',
        //     country_id integer,
        //     status BOOL DEFAULT false,
        //     mbid VARCHAR(200) DEFAULT '',
        //     FOREIGN KEY (country_id) REFERENCES countries(id)
        //   )");

        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_name ON artists (name);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_country_id ON artists (country_id);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE artists CASCADE");
    }
};