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
            $table->string('bio_tk')->default('');
            $table->string('bio_ru')->default('');
            $table->timestamp('added_date')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->string('artwork_url')->default('');
            $table->string('thumb_url')->default('');
            $table->boolean('status');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('mbind', 200)->default('');
            $table->timestamps();

            $table->index('name', 'idx_artist_name');
            $table->index('country_id', 'artist_cauntry_idx');
            $table->foreign('country_id', 'arists_countries_fk')->on('countries')->references('id');
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