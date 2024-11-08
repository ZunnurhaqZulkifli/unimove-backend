<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name'            => 'Library',
                'code'            => 'LBRY',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '5 Mins',
                'status'          => 'active'
            ],
            [
                'name'            => 'Male Student Dorm 1',
                'code'            => 'MSTD 1',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '3 Mins',
                'status'          => 'active'
            ],
            [
                'name'            => 'Female Student Dorm 1',
                'code'            => 'FSTD 1',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '7 Mins',
                'status'          => 'active'
            ],
            [
                'name'            => 'Faculty of Science',
                'code'            => 'FOSC',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '4 Mins',
                'status'          => 'active'
            ],
            [
                'name'            => 'Faculty of Education',
                'code'            => 'FOED',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '4 Mins',
                'status'          => 'active'
            ],
            [
                'name'            => 'Faculty of Engineering',
                'code'            => 'FOEG',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '9 Mins',
                'status'          => 'active'
            ],
            [
                'name'            => 'Faculty of Social Science',
                'code'            => 'FOSS',
                'address'         => 'xxx',
                'price'           => 5.00,
                'estimation-time' => '4 Mins',
                'status'          => 'active'
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
