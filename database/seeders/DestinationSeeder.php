<?php

namespace Database\Seeders;

use App\Models\Destination;
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
                'name'            => 'Library / ATM',
                'code'            => 'LBR',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 2,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Admin',
                'code'            => 'ADM',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 2,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Murni',
                'code'            => 'SAM',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Amanah',
                'code'            => 'SAA',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 3,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Cendi',
                'code'            => 'SAC',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Ilmu',
                'code'            => 'SAI',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'College of Engineering',
                'code'            => 'COE',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'College of Information Technology',
                'code'            => 'COIT',
                'price'           => 3.00,
                'x'               => 3,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Uniten Food Court',
                'code'            => 'UFC',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 2,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Uniten Mosque',
                'code'            => 'UNM',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 2,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Uniten Residence Hotel',
                'code'            => 'URH',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Sports Arena Center',
                'code'            => 'SACE',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Dewan Seri Sarjana',
                'code'            => 'DSS',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 1,
                'estimation_time' => 1,
                'image'           => 'library.jpg',
                'status'          => 'active',
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
