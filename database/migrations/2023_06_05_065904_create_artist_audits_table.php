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
        Schema::create('artist_audits', function (Blueprint $table) {
            $table->id();
            $table->string('tracks')->nullable();
            $table->string('albums')->nullable();
            $table->unsignedBigInteger('audit_id');
            $table->timestamps();

            $table->index('audit_id', 'artist_audits_audits_idx');
            $table->foreign('audit_id', 'artist_audits_audits_fk')->on('audits')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_audits');
    }
};
