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
        Schema::create('artist_track', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->unsignedBigInteger('track_id')->nullable();

            $table->primary(['artist_id', 'track_id']);

            $table->index('artist_id', 'artist_track_idx');
            $table->index('track_id', 'track_artist_idx');

            $table->foreign('artist_id', 'artist_track_fk')->on('artists')->references('id');
            $table->foreign('track_id', 'track_artist_fk')->on('tracks')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_tracks');
    }
};