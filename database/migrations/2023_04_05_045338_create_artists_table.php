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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bio')->default('');
            $table->timestamp('added_date')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->string('artwork_url')->default('');
            $table->string('thumb_url')->default('');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->index('name', 'idx_artist_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
