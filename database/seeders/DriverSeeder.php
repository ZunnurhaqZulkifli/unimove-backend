<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(3);

        $drivers = [
            [
                'name'           => $user->name,
                'phone'          => $user->email,
                'driver_id'      => 'DRV 0001',
                'license_no'     => 'SJD 1234',
                'license_expiry' => '2024',
                'address'        => 'JALAN',
                'ratings'        => 2,
                'total_trips'    => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}
