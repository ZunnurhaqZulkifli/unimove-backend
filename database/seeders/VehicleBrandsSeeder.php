<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Toyota',
            'Honda',
            'Nissan',
            'Mitsubishi',
            'Suzuki',
            'Ford',
            'Hyundai',
            'Kia',
            'Proton',
            'Perodua',
        ];

        foreach ($brands as $brand) {
            VehicleBrand::create(['name' => $brand]);
        }
    }
}
