<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'driver_id' => 1,
                'plate_no' => 'WQW 1234',
                'model_id' => 1,
                'brand_id' => 1,
                'color' => 'red',
                'mileage' => '100000',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'driver_id' => 1,
                'plate_no' => 'QUW 9123',
                'model_id' => 10,
                'brand_id' => 2,
                'color' => 'green',
                'mileage' => '20000',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
