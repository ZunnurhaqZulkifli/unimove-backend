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
        $users = [
            [
                'name'              => 'System Administrator',
                'username'          => '01001239123',
                'email'             => 'admin@example.test',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => random_int(0, 100),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

              // Student
            [
                'name'              => 'Alice',
                'username'          => '000826128788',
                'email'             => 'alice@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => random_int(0, 100),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

              // Driver
            [
                'name'              => 'Abu',
                'username'          => '951127918819',
                'email'             => 'abu1@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => random_int(0, 100),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
