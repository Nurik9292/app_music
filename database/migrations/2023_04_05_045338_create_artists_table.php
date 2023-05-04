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
        DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS artists CASCADE");
        DB::connection('pgsql_prod')->statement("
        CREATE TABLE artists (
            id serial PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            bio_tk TEXT DEFAULT '',
            bio_ru TEXT DEFAULT '',
            artwork_url VARCHAR(255) DEFAULT '',
            thumb_url VARCHAR(255) DEFAULT '',
            country_id integer,
            status BOOL DEFAULT false,
            mbid VARCHAR(200) DEFAULT '',
            FOREIGN KEY (country_id) REFERENCES countries(id)
          )");

        DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_name ON artists (name);");
        DB::connection('pgsql_prod')->statement("CREATE INDEX idx_artist_country_id ON artists (country_id);");


        // Schema::create('artists', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('bio_tk')->default('');
        //     $table->string('bio_ru')->default('');
        //     $table->timestamp('added_date')->nullable();
        //     $table->timestamp('last_update')->nullable();
        //     $table->string('artwork_url')->default('');
        //     $table->string('thumb_url')->default('');
        //     $table->boolean('status');
        //     $table->unsignedBigInteger('country_id')->nullable();
        //     $table->string('mbind', 200)->default('');
        //     $table->timestamps();

        //     $table->index('name', 'idx_artist_name');
        //     $table->index('country_id', 'artist_cauntry_idx');
        //     $table->foreign('country_id', 'arists_countries_fk')->on('countries')->references('id');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE artists CASCADE");
        // Schema::dropIfExists('artists');
    }
};