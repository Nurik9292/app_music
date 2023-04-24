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
        Schema::create('genre_tracks', function (Blueprint $table) {
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->unsignedBigInteger('track_id')->nullable();

            $table->primary(['genre_id', 'track_id']);

            $table->index('genre_id', 'genre_track_idx');
            $table->index('track_id', 'track_genre_idx');

            $table->foreign('genre_id', 'genre_track_fk')->on('genres')->references('id');
            $table->foreign('track_id', 'track_genre_fk')->on('tracks')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_tracks');
    }
};