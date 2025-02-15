<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'fname' => "Renato",
            'lname' => "Admin",
            'email' => "renato.arenas2012@gmail.com",
            'password' => Hash::make("admin")
        ]);

        $admin->assignRole('admin');

        $seller = User::create([
            'fname' => "Renato",
            'lname' => "Vendedor",
            'email' => "renato.arenas2013@gmail.com",
            'password' => Hash::make("seller")
        ]);

        $seller->assignRole('seller');
    }
}
