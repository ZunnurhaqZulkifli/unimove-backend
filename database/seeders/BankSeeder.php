<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name'       => 'Maybank',
                'code'       => 'MYB',
                'created_at' => now(),
            ],
            [
                'name'       => 'CIMB',
                'code'       => 'CMB',
                'created_at' => now(),
            ],
            [
                'name'       => 'AFFIN BANK',
                'code'       => 'AFN',
                'created_at' => now(),
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
