<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS album_track CASCADE");

        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE album_track (
        //     album_id bigint,
        //     track_id bigint,
        //     PRIMARY KEY (album_id, track_id),
        //     FOREIGN KEY (album_id) REFERENCES albums(id),
        //     FOREIGN KEY (track_id) REFERENCES tracks(id)
        //   );
        //   ");

        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_album_track_track_id ON album_track (track_id);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_album_track_album_id ON album_track (album_id);");


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE album_track CASCADE");
    }
};
