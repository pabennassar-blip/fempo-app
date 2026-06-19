<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if doesn't exist
        User::updateOrCreate(
            ['email' => 'admin@fempo.local'],
            [
                'name' => 'Admin FEMPO',
                'email' => 'admin@fempo.local',
                'password' => Hash::make('pterodactyl'),
            ]
        );

        $this->command->info('Usuario admin creado: admin@fempo.local / pterodactyl');
    }
}
