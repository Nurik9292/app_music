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

        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS genre_playlist CASCADE");

        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE genre_playlist (
        //     playlist_id bigint,
        //     genre_id integer,
        //     PRIMARY KEY (playlist_id, genre_id),
        //     FOREIGN KEY (playlist_id) REFERENCES playlists(id),
        //     FOREIGN KEY (genre_id) REFERENCES genres(id)
        //   );
        //   ");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_genre_playlist_playlist_id ON genre_playlist (playlist_id);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_genre_playlist_genre_id ON genre_playlist (genre_id);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE genre_playlist CASCADE");
    }
};