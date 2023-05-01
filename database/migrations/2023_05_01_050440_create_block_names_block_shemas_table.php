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
        Schema::create('block_names_block_shema', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_name_id')->nullable();
            $table->unsignedBigInteger('block_shema_id')->nullable();

            $table->index('block_name_id', 'block_name_block_shema_idx');
            $table->index('block_shema_id', 'block_shema_block_name_idx');

            $table->foreign('block_name_id', 'block_name_block_shema_fk')->on('block_names')->references('id');
            $table->foreign('block_shema_id', 'block_shema_block_name_fk')->on('block_shema')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_block_shemas');
    }
};