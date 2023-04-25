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
        DB::statement(" DROP TYPE IF EXISTS album_type");
        DB::statement("CREATE TYPE album_type AS ENUM('album', 'single', 'soundtrack', 'live', 'remix')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TYPE album_type CASCADE");
    }
};