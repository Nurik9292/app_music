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
        CREATE TABLE genres (
            id serial PRIMARY KEY,
            name_tm VARCHAR(50) NOT NULL,
            name_ru VARCHAR(50) NOT NULL,
            parent_id integer DEFAULT 0
          );");

        DB::statement("CREATE INDEX idx_genre_name_tk ON genres (name_tm);");
        DB::statement("CREATE INDEX idx_genre_name_ru ON genres (name_ru);");
        // Schema::create('genres', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name_tm');
        //     $table->string('name_ru');
        //     $table->unsignedBigInteger('parent_id')->default(0);

        //     $table->index('name_tm', 'idx_genre_name_tm');
        //     $table->index('name_ru', 'idx_genre_name_ru');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE genres CASCADE");
        Schema::dropIfExists('genres');
    }
};