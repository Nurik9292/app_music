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
        DB::statement("
        CREATE TABLE album_track (
            album_id bigint,
            track_id bigint,
            PRIMARY KEY (album_id, track_id),
            FOREIGN KEY (album_id) REFERENCES albums(id),
            FOREIGN KEY (track_id) REFERENCES tracks(id)
          );
          ");

        DB::statement("CREATE INDEX idx_album_track_track_id ON album_track (track_id);");
        DB::statement("CREATE INDEX idx_album_track_album_id ON album_track (album_id);");

        // Schema::create('album_track', function (Blueprint $table) {
        //     $table->unsignedBigInteger('album_id')->nullable();
        //     $table->unsignedBigInteger('track_id')->nullable();

        //     $table->primary(['album_id', 'track_id']);

        //     $table->index('album_id', 'album_track_idx');
        //     $table->index('track_id', 'track_album_idx');

        //     $table->foreign('album_id', 'album_track_fk')->on('albums')->references('id');
        //     $table->foreign('track_id', 'track_album_fk')->on('tracks')->references('id');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE album_track CASCADE");

        // Schema::dropIfExists('album_track');
    }
};