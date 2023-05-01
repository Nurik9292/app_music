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
        Schema::create('block_shema_playlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_shema_id')->nullable();
            $table->unsignedBigInteger('playlist_id')->nullable();

            $table->index('block_shema_id', 'block_shema_playlist_idx');
            $table->index('playlist_id', 'playlist_block_shema_idx');

            $table->foreign('block_shema_id', 'block_shema_playlist_fk')->on('block_shema')->references('id');
            $table->foreign('playlist_id', 'playlist_block_shema_fk')->on('playlists')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_shema_playlists');
    }
};