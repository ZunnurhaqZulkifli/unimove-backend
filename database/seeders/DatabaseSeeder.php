<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Auto Resetting Database');

        $this->command->call('migrate');

        $this->command->call('db:wipe');
        $this->command->call('migrate:refresh');

        $this->command->info('Seeding Users');

        $this->call([
            UserSeeder::class,
            BankSeeder::class,
            DriverSeeder::class,
            StudentSeeder::class,
            // AttachUserType::class,
        ]);
    }
}
