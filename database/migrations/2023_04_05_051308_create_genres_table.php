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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string('name_tm');
            $table->string('name_ru');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->timestamps();

            $table->index('name_tm', 'idx_genre_name_tm');
            $table->index('name_ru', 'idx_genre_name_ru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};