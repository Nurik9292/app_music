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

        DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS artist_album CASCADE");

        DB::connection('pgsql_prod')->statement("
        CREATE TABLE artist_album (
            artist_id integer,
            album_id bigint,
            PRIMARY KEY (artist_id, album_id),
            FOREIGN KEY (artist_id) REFERENCES artists(id),
            FOREIGN KEY (album_id) REFERENCES albums(id)
          );");
        DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_album_album_id ON artist_album (album_id);");
        DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_album_artist_id ON artist_album (artist_id);");

        // Schema::create('artist_album', function (Blueprint $table) {
        //     $table->unsignedBigInteger('artist_id')->nullable();
        //     $table->unsignedBigInteger('album_id')->nullable();

        //     $table->primary(['artist_id', 'album_id']);

        //     $table->index('artist_id', 'idx_artist_album_artist_id');
        //     $table->index('album_id', 'idx_artist_album_album_id');

        //     $table->foreign('artist_id', 'artist_album_artist_id_fk')->on('artists')->references('id');
        //     $table->foreign('album_id', 'artist_album_album_id_fk')->on('albums')->references('id');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE album_track CASCADE");
        // Schema::dropIfExists('artist_albums');
    }
};