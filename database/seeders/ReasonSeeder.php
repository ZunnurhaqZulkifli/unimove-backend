<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            [
                'label'  => 'Personal Emergency',
                'value'  => 'Personal Emergency',
            ],
            [
                'label'  => 'Other Emergencies',
                'value'  => 'Other Emergencies',
            ],
            [
                'label'  => 'Wrong Destination',
                'value'  => 'Wrong Destination',
            ],
            [
                'label'  => 'Low Wallet Balance',
                'value'  => 'Low Wallet Balance',
            ],
            [
                'label'  => 'Incorrect Authorization Code',
                'value'  => 'Incorrect Authorization Code',
            ],
            [
                'label'  => 'Other Reason',
                'value'  => 'Other Reason',
            ],
        ];

        foreach ($reasons as $reason) {
            Reason::create($reason);
        }
    }
}
