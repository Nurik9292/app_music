<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE TABLE playlists (
            id bigserial PRIMARY KEY,
            title_tm VARCHAR(255) NOT NULL,
            title_ru VARCHAR(255) NOT NULL,
            status BOOL DEFAULT false,
            artwork_url VARCHAR(255) DEFAULT '',
            thumb_url VARCHAR(255) DEFAULT '',
            show_count INT DEFAULT 0,
            created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
          );
          ");
        DB::statement("CREATE INDEX idx_playlist_title_tm ON playlists (title_tm);");
        DB::statement("CREATE INDEX idx_playlist_title_ru ON playlists (title_ru);");

        // Schema::create('playlists', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title_tm');
        //     $table->string('title_ru');
        //     $table->string('artwork_url')->default('');
        //     $table->string('thumb_url')->default('');
        //     $table->boolean('status')->default(false);
        //     $table->integer('show_count')->default(0);
        //     $table->timestamps();

        //     $table->index('title_tm', 'idx_playlist_title_tm');
        //     $table->index('title_ru', 'idx_playlist_title_ru');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE playlists CASCADE");
        Schema::dropIfExists('playlists');
    }
};