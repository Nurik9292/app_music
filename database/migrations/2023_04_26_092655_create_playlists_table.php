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
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('title_tm');
            $table->string('title_ru');
            $table->string('artwork_url')->default('');
            $table->string('thumb_url')->default('');
            $table->boolean('status')->default(false);
            $table->integer('show_count')->default(0);
            $table->timestamps();

            $table->index('title_tm', 'idx_playlist_title_tm');
            $table->index('title_ru', 'idx_playlist_title_ru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlists');
    }
};
