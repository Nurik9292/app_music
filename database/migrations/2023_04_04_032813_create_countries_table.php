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
        DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS countries CASCADE");
        DB::connection('pgsql_prod')->statement("
        CREATE TABLE countries (
            id serial PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            code VARCHAR(3) NOT NULL
         );
        ");

        // Schema::create('countries', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('code', 3);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_prod')->statement("DROP TABLE countries CASCADE");
        // Schema::dropIfExists('countries');
    }
};