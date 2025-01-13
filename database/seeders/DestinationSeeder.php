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
                'image_l'         => 'images/library2_l.jpg',
                'image_p'         => 'images/library_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Admin',
                'code'            => 'ADM',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 2,
                'estimation_time' => 1,
                'image_l'         => 'images/admin_l.jpg',
                'image_p'         => 'images/admin_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Murni',
                'code'            => 'SAM',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/murni_l.jpg',
                'image_p'         => 'images/murni_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Amanah',
                'code'            => 'SAA',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 3,
                'estimation_time' => 1,
                'image_l'         => 'images/amanah_l.jpg',
                'image_p'         => 'images/amanah_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Cendi',
                'code'            => 'SAC',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/cendi_l.jpg',
                'image_p'         => 'images/cendi_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Student APT Ilmu',
                'code'            => 'SAI',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/ilmu_l.jpg',
                'image_p'         => 'images/ilmu_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'College of Engineering',
                'code'            => 'COE',
                'price'           => 3.00,
                'x'               => 0,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/coe_l.jpg',
                'image_p'         => 'images/coe_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'College of Information Technology',
                'code'            => 'COIT',
                'price'           => 3.00,
                'x'               => 3,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/college_it_l.jpg',
                'image_p'         => 'images/college_it_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Uniten Food Court',
                'code'            => 'UFC',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 2,
                'estimation_time' => 1,
                'image_l'         => 'images/food_court_l.jpg',
                'image_p'         => 'images/food_court_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Uniten Royal Park Hotel',
                'code'            => 'URH',
                'price'           => 3.00,
                'x'               => 1,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/royal_l.jpg',
                'image_p'         => 'images/royal_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Sports Arena Center',
                'code'            => 'SACE',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/arena_l.jpg',
                'image_p'         => 'images/arena_p.jpg',
                'status'          => 'active',
            ],
            [
                'name'            => 'Dewan Seri Sarjana',
                'code'            => 'DSS',
                'price'           => 3.00,
                'x'               => 2,
                'y'               => 1,
                'estimation_time' => 1,
                'image_l'         => 'images/dewan_sarjana_l.jpg',
                'image_p'         => 'images/dewan_sarjana_p.jpg',
                'status'          => 'active',
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
