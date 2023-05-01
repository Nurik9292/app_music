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
        Schema::create('album_block_shema', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_shema_id')->nullable();
            $table->unsignedBigInteger('album_id')->nullable();

            $table->index('block_shema_id', 'block_shema_album_idx');
            $table->index('album_id', 'album_block_shema_idx');

            $table->foreign('block_shema_id', 'block_shema_album_fk')->on('block_shema')->references('id');
            $table->foreign('album_id', 'album_block_shema_fk')->on('albums')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_block_shema');
    }
};