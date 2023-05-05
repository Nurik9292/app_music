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
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS artist_track CASCADE");

        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE artist_track (
        //     artist_id integer,
        //     track_id bigint,
        //     PRIMARY KEY (artist_id, track_id),
        //     FOREIGN KEY (artist_id) REFERENCES artists(id),
        //     FOREIGN KEY (track_id) REFERENCES tracks(id)
        //   );");

        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_track_track_id ON artist_track (track_id);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_track_artist_id ON artist_track (artist_id);");


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE artist_track CASCADE");
    }
};