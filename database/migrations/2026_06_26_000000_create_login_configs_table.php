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
        Schema::create('login_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 'default' o 'admin', etc.
            $table->string('image1_path')->default('src/logo_govern_illes_balears.png');
            $table->string('image2_path')->nullable();
            $table->string('version')->default('1.0.0');
            $table->text('login_title')->default('INICIAR SESSIÓ');
            $table->text('login_subtitle')->nullable();
            $table->boolean('show_help_text')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_configs');
    }
};
