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
        CREATE TABLE tracks (
            id bigserial PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            duration INT NOT NULL,
            track_number INT DEFAULT 1,
            bit_rate INT NOT NULL,
            lyrics TEXT,
            audio_url VARCHAR(255) NOT NULL,
            mbid VARCHAR(200) DEFAULT '',
            is_national BOOL DEFAULT false,
            thumb_url VARCHAR(255) DEFAULT '',
            deleted_at timestamp(0) without time zone,
            lissen_count INT DEFAULT 0,
            status BOOL DEFAULT false
          );");

        DB::statement("CREATE INDEX idx_track_title ON tracks (title);");

        // Schema::create('tracks', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title', 100);
        //     $table->unsignedBigInteger('duration');
        //     $table->unsignedBigInteger('track_number')->default(1);
        //     $table->unsignedBigInteger('bit_rate');
        //     $table->text('lyrics')->nullable();
        //     $table->string('audio_url')->default('');
        //     $table->boolean('is_national')->default('false');
        //     $table->boolean('status')->default('false');
        //     $table->string('thumb_url')->default('');
        //     $table->unsignedBigInteger('listen_count')->default(0);
        //     $table->string('mbind', 200)->default('');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE tracks CASCADE");
        // Schema::dropIfExists('tracks');
    }
};