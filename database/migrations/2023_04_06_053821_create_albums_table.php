<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\Schema\PostgresBuilder;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Elements\Type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // DB::connection('pgsql_prod')->statement("
        // CREATE TABLE albums (
        //     id bigserial PRIMARY KEY,
        //     title VARCHAR(255) NOT NULL,
        //     release_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //     status BOOL DEFAULT false,
        //     artwork_url VARCHAR(255) DEFAULT '',
        //     thumb_url VARCHAR(255) DEFAULT '',
        //     description TEXT DEFAULT '',
        //     type album_type NOT NULL DEFAULT 'album',
        //     mbid VARCHAR(200) DEFAULT '',
        //     is_national BOOL DEFAULT false,
        //     show_count INT DEFAULT 0
        //   );");

        // DB::connection('pgsql_prod')->statement("CREATE INDEX idx_album_title ON albums (title);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::connection('pgsql_prod')->statement("DROP TABLE albums CASCADE");
    }
};
