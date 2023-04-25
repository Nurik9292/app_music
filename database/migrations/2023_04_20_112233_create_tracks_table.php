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

        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->unsignedBigInteger('duration');
            $table->unsignedBigInteger('track_number')->default(1);
            $table->unsignedBigInteger('bit_rate');
            $table->text('lyrics')->nullable();
            $table->string('audio_url')->default('');
            $table->boolean('is_national')->default('false');
            $table->boolean('status')->default('false');
            $table->string('thumb_url')->default('');
            $table->unsignedBigInteger('listen_count')->default(0);
            $table->string('mbind', 200)->default('');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('tracks');
    }
};