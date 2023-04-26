<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlist_track', function (Blueprint $table) {
            $table->unsignedBigInteger('playlist_id')->nullable();
            $table->unsignedBigInteger('track_id')->nullable();
            $table->primary(['playlist_id', 'track_id']);

            $table->index('playlist_id', 'idx_playlist_track_playlist');
            $table->index('track_id', 'idx_playlist_track_track');

            $table->foreign('playlist_id', 'playlist_track_playlist_fk')->on('playlists')->references('id');
            $table->foreign('track_id', 'playlist_track_track_fk')->on('tracks')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_tracks');
    }
};
