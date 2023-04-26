<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('album_track', function (Blueprint $table) {
            $table->unsignedBigInteger('album_id')->nullable();
            $table->unsignedBigInteger('track_id')->nullable();

            $table->primary(['album_id', 'track_id']);

            $table->index('album_id', 'album_track_idx');
            $table->index('track_id', 'track_album_idx');

            $table->foreign('album_id', 'album_track_fk')->on('albums')->references('id');
            $table->foreign('track_id', 'track_album_fk')->on('tracks')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_tracks');
    }
};