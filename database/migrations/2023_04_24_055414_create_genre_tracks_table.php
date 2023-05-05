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

        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS genre_track CASCADE");

        // DB::connection('pgsql_prod')->statement("
        //     CREATE TABLE genre_track (
        //     track_id bigserial,
        //     genre_id integer,
        //     PRIMARY KEY (track_id, genre_id),
        //     FOREIGN KEY (track_id) REFERENCES tracks(id),
        //     FOREIGN KEY (genre_id) REFERENCES genres(id)
        //   );");

        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_genre_track_track_id ON genre_track (track_id);");
        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_genre_track_genre_id ON genre_track (genre_id);");

        // Schema::create('genre_track', function (Blueprint $table) {
        //     $table->unsignedBigInteger('genre_id')->nullable();
        //     $table->unsignedBigInteger('track_id')->nullable();

        //     $table->primary(['genre_id', 'track_id']);

        //     $table->index('genre_id', 'genre_track_idx');
        //     $table->index('track_id', 'track_genre_idx');

        //     $table->foreign('genre_id', 'genre_track_fk')->on('genres')->references('id');
        //     $table->foreign('track_id', 'track_genre_fk')->on('tracks')->references('id');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE genre_track CASCADE");
        // Schema::dropIfExists('genre_track');
    }
};