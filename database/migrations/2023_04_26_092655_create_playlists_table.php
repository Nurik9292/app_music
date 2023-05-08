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
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS playlists CASCADE");
        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE playlists (
        //     id bigserial PRIMARY KEY,
        //     title_tm VARCHAR(255) NOT NULL,
        //     title_ru VARCHAR(255) NOT NULL,
        //     status BOOL DEFAULT false,
        //     artwork_url VARCHAR(255) DEFAULT '',
        //     thumb_url VARCHAR(255) DEFAULT '',
        //     show_count INT DEFAULT 0,
        //     created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        //   );
        //   ");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_playlist_title_tm ON playlists (title_tm);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_playlist_title_ru ON playlists (title_ru);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE playlists CASCADE");
        // Schema::dropIfExists('playlists');
    }
};
