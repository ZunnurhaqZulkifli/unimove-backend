<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Toyota' => [
                'Vios',
                'Yaris',
                'Corolla Altis',
                'Camry',
                'Innova',
                'Fortuner',
                'Hilux',
                'Rush',
                'Avanza',
                'Alphard',
                'Vellfire',
                'Harrier',
                'RAV4',
                'C-HR',
                'Corolla Cross',
                'Hiace',
                'Estima',
                'Previa',
                'Land Cruiser',
                'Land Cruiser Prado',
            ],

            'Honda' => [
                'City',
                'Jazz',
                'Civic',
                'Accord',
                'HR-V',
                'BR-V',
                'CR-V',
                'Odyssey',
                'Civic Type R',
            ],

            'Nissan' => [
                'Almera',
                'Sylphy',
                'Teana',
                'X-Trail',
                'Kicks',
                'Navara',
                'Serena',
                'Leaf',
                'GT-R',
            ],

            'Mitsubishi' => [
                'Attrage',
                'Lancer',
                'ASX',
                'Outlander',
                'Pajero Sport',
                'Triton',
                'Xpander',
            ],

            'Suzuki' => [
                'Swift',
                'Dzire',
                'Ciaz',
                'Ertiga',
                'Vitara',
                'Jimny',
            ],

            'Ford' => [
                'Fiesta',
                'Focus',
                'Mustang',
                'EcoSport',
                'Kuga',
                'Ranger',
                'Everest',
            ],

            'Hyundai' => [
                'Accent',
                'Elantra',
                'Ioniq',
                'Kona',
                'Santa Fe',
                'Starex',
                'Tucson',
                'Veloster',
            ],

            'Kia' => [
                'Picanto',
                'Rio',
                'Cerato',
                'Optima',
                'Sorento',
                'Sportage',
                'Stinger',
            ],

            'Proton' => [
                'Saga',
                'Persona',
                'Iriz',
                'Preve',
                'Exora',
                'X70',
                'X50',
            ],

            'Perodua' => [
                'Axia',
                'Bezza',
                'Myvi',
                'Alza',
                'Aruz',
            ],
        ];

        foreach ($models as $brand => $models) {
            foreach ($models as $model) {
                VehicleModel::create([
                    'name' => $model,
                    'brand_id' => VehicleBrand::where('name', $brand)->first()->id,
                ]);
            }
        }
    }
}
