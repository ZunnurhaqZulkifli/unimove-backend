<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use App\Models\Wallet;
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
                'license_no'     => 'LSN 9123',
                'license_expiry' => '2024',
                'address'        => 'JALAN',
                'ratings'        => 2,
                'total_trips'    => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        foreach ($drivers as $driver) {
            $profile = Driver::create($driver);
            $user->profile()->associate($profile);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 50.00,
                'bank_id' => 1,
                'card_number' => '1234567812356',
                'card_expiry' => '1/28',
                'card_ccv' => '392',
                'card_holder' => $user->name,
                'card_type' => 'debit',
            ]);

            $user->save();
        }
    }
}
