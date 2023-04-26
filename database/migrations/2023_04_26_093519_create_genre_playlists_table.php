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
        Schema::create('genre_playlist', function (Blueprint $table) {
            $table->unsignedBigInteger('playlist_id')->nullable();
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->primary(['playlist_id', 'genre_id']);

            $table->index('playlist_id', 'idx_genre_playlist_playlist');
            $table->index('genre_id', 'idx_genre_playlist_genre');

            $table->foreign('playlist_id', 'genre_playlist_playlist_fk')->on('playlists')->references('id');
            $table->foreign('genre_id', 'genre_playlist_genre_fk')->on('genres')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_playlists');
    }
};
