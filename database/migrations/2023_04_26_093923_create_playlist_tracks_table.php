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

        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS playlist_tracks CASCADE");

        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE playlist_tracks (
        //     playlist_id bigint,
        //     track_id bigint,
        //     PRIMARY KEY (playlist_id, track_id),
        //     FOREIGN KEY (playlist_id) REFERENCES playlists(id),
        //     FOREIGN KEY (track_id) REFERENCES tracks(id)
        //   );");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_playlist_tracks_playlist_id ON playlist_tracks (playlist_id);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_playlist_tracks_track_id ON playlist_tracks (track_id);");


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE playlist_track CASCADE");
        // Schema::dropIfExists('playlist_track');
    }
};