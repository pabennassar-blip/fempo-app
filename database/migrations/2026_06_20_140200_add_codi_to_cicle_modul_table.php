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
        Schema::table('cicle_modul', function (Blueprint $table) {
            $table->string('cicle_codi')->nullable()->after('cicle_id');
            $table->string('modul_codi')->nullable()->after('modul_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cicle_modul', function (Blueprint $table) {
            $table->dropColumn(['cicle_codi', 'modul_codi']);
        });
    }
};
