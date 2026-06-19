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
        Schema::table('cicles', function (Blueprint $table) {
            $table->string('familia')->nullable()->after('abreviatura');
            $table->string('grau')->nullable()->after('familia');
            $table->string('nivell')->nullable()->after('grau');
            $table->string('estudi')->nullable()->after('nivell');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cicles', function (Blueprint $table) {
            $table->dropColumn(['familia', 'grau', 'nivell', 'estudi']);
        });
    }
};
