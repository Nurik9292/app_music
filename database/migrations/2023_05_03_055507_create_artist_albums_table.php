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
        Schema::create('artist_album', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->unsignedBigInteger('album_id')->nullable();

            $table->primary(['artist_id', 'album_id']);

            $table->index('artist_id', 'idx_artist_album_artist_id');
            $table->index('album_id', 'idx_artist_album_album_id');

            $table->foreign('artist_id', 'artist_album_artist_id_fk')->on('artists')->references('id');
            $table->foreign('album_id', 'artist_album_album_id_fk')->on('albums')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_albums');
    }
};