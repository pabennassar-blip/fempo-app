<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Professor;
use App\Models\Alumne;
use App\Models\Empresari;
use App\Models\Contract;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear contrato (idempotent)
        $contract = Contract::firstOrCreate(
            ['name' => 'Pràctiques IES Sineu'],
            ['name' => 'Pràctiques IES Sineu']
        );

        // Crear professor (idempotent)
        $professor = User::updateOrCreate(
            ['email' => 'professor@example.com'],
            [
                'name' => 'María García',
                'password' => Hash::make('password123'),
            ]
        );
        Professor::updateOrCreate(
            ['user_id' => $professor->id],
            [
                'user_id' => $professor->id,
                'curs' => 'DAW 2n',
            ]
        );

        // Obtenir la primera empresa per assignar-la
        $empresa = Empresa::first();

        // Crear alumne (idempotent)
        $alumne = User::updateOrCreate(
            ['email' => 'alumne@example.com'],
            [
                'name' => 'Juan López',
                'password' => Hash::make('password123'),
            ]
        );
        Alumne::updateOrCreate(
            ['user_id' => $alumne->id],
            [
                'user_id' => $alumne->id,
                'numero_seguretat_social' => '123456789012',
            ]
        );

        // Crear empresari (idempotent)
        $empresariUser = User::updateOrCreate(
            ['email' => 'empresari@example.com'],
            [
                'name' => 'Carlos Martínez',
                'password' => Hash::make('password123'),
            ]
        );
        if ($empresa) {
            Empresari::updateOrCreate(
                ['user_id' => $empresariUser->id],
                [
                    'user_id' => $empresariUser->id,
                    'empresa_id' => $empresa->id,
                ]
            );
        }

        // Asignar usuarios al contrato (sin duplicados)
        if (!$contract->users()->where('user_id', $professor->id)->exists()) {
            $contract->users()->attach([$professor->id, $alumne->id, $empresariUser->id]);
        }

    }
}
