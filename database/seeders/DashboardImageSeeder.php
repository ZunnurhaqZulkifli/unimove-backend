<?php

namespace Database\Seeders;

use App\Models\DashboardImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DashboardImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [
                'name' => 'dashboard_1',
                'path' => 'images/dashboard_1.jpg',
            ],

            [
                'name' => 'dashboard_2',
                'path' => 'images/dashboard_2.jpg',
            ],

            [
                'name' => 'dashboard_3',
                'path' => 'images/dashboard_3.jpg',
            ],

            [
                'name' => 'dashboard_4',
                'path' => 'images/dashboard_4.jpg',
            ],

            [
                'name' => 'dashboard_5',
                'path' => 'images/dashboard_5.jpg',
            ],
        ];

        foreach ($images as $image) {
            DashboardImage::create($image);
        }
    }
}
