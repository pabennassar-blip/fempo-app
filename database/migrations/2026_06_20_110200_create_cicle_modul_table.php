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
        Schema::create('cicle_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cicle_id')->constrained('cicles')->onDelete('cascade');
            $table->foreignId('modul_id')->constrained('moduls')->onDelete('cascade');
            $table->timestamps();
            
            // Evita duplicats
            $table->unique(['cicle_id', 'modul_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicle_modul');
    }
};
