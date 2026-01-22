<?php

namespace Database\Seeders;

use App\Models\Mobil;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Supiryadi',
            'email' => 'supir@example.com',
            'password' => Hash::make('password'),
        ]);

        Mobil::create([
            'plat' => 'DA 1111 VAN',
            'jenis' => 'Dump Truck',
        ]);

    }
}
