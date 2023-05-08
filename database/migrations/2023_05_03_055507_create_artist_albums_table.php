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

        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS artist_album CASCADE");

        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE artist_album (
        //     artist_id integer,
        //     album_id bigint,
        //     PRIMARY KEY (artist_id, album_id),
        //     FOREIGN KEY (artist_id) REFERENCES artists(id),
        //     FOREIGN KEY (album_id) REFERENCES albums(id)
        //   );");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_album_album_id ON artist_album (album_id);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_album_artist_id ON artist_album (artist_id);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE album_track CASCADE");
        // Schema::dropIfExists('artist_albums');
    }
};
