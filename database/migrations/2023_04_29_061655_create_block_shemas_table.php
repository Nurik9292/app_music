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
        // DB::connection('pgsql_prod')->statement("DROP TABLE IF EXISTS bloc_shema CASCADE");
        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE bloc_shema (
        //     id serial PRIMARY KEY,
        //     name VARCHAR(50) NOT NULL,
        //     body json NOT NULL,
        //     order_number INT NOT NULL,
        //     status BOOL DEFAULT false
        //   );");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE bloc_shema CASCADE");
        // Schema::connection('pgsql_prod')->dropIfExists('bloc_shema');
    }
};