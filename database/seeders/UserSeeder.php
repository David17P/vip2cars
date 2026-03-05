<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vip2cars.com'],
            [
                'name'              => 'Administrador VIP2CARS',
                'email'             => 'admin@vip2cars.com',
                'password'          => Hash::make('vip2cars2026'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Usuario demo creado:');
        $this->command->info('Email   : admin@vip2cars.com');
        $this->command->info('Password: vip2cars2026');
        
    }
}
