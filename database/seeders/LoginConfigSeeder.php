<?php

namespace Database\Seeders;

use App\Models\LoginConfig;
use Illuminate\Database\Seeder;

class LoginConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Configuració per defecte del login principal
        LoginConfig::updateOrCreate(
            ['key' => 'default'],
            [
                'image1_path' => 'src/logo_govern_illes_balears.png',
                'image2_path' => null,
                'version' => '2.0.0',
                'login_title' => 'INICIAR SESSIÓ',
                'login_subtitle' => null,
                'show_help_text' => true,
            ]
        );

        // Configuració per al chat
        LoginConfig::updateOrCreate(
            ['key' => 'chat'],
            [
                'image1_path' => 'src/logo_govern_illes_balears.png',
                'image2_path' => null,
                'version' => '1.0.0',
                'login_title' => 'Iniciar Sessió',
                'login_subtitle' => null,
                'show_help_text' => true,
            ]
        );
    }
}
