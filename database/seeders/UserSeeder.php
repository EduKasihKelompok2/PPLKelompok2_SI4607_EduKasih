<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            'name' => 'ZHARIF SELALU REDY',
            'gender' => 'male',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'dob' => '2000-01-01',
            'institution' => 'SMK NEGERI 1 KEDUNGWARU',
        ];

        $user = \App\Models\User::create($userData);
        $user->assignRole('user');


        $adminData = [
            'name' => 'ADMINISTRATOR',
            'gender' => 'female',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'dob' => '1990-01-01',
            'institution' => 'ADMIN INSTITUTION',
        ];

        $admin = \App\Models\User::create($adminData);
        $admin->assignRole('admin');
    }
}
