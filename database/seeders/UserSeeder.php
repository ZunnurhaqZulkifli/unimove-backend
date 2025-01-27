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
                'name'              => 'Zunnurhaq Driver',
                'username'          => '918238128312',
                'email'             => 'b',
                'email_verified_at' => now(),
                'password'          => Hash::make('b'),
                'remember_token'    => random_int(0, 100),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'name'              => 'Zunnurhaq',
                'username'          => '010614010959',
                'email'             => 'a',
                'email_verified_at' => now(),
                'password'          => Hash::make('a'),
                'remember_token'    => random_int(0, 100),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            [
                'name'              => 'Student 04',
                'username'          => '01293912392',
                'email'             => 'c',
                'email_verified_at' => now(),
                'password'          => Hash::make('c'),
                'remember_token'    => random_int(0, 100),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        foreach($users as $key => $user) {
            $user = User::find($key + 1);

            $user->biometric()->create([
                    'face_id'        => false,
                    'passcode'       => true,
                    'fingerprint'    => false,
                    'enabled'        => false,
                    'passcode_number' => '000000',
            ]);

            $user->save();
        }
    }
}
