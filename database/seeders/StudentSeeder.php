<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(4);
        $students = [
            [
                'student_id' => 'CS001',
                'address' => 'JALAN',
                'name' => $user->name,
                'phone' => '0123456789',
                'status' => 'active',
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($students as $student) {
            $profile  = Student ::create($student);
            $user->profile()->associate($profile);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 50.00,
                'bank_id' => 1,
                'card_number' => '123567812356',
                'card_expiry' => '12/25',
                'card_ccv' => '123',
                'card_holder' => $user->name,
                'card_type' => 'debit',
            ]);

            $user->save();
        }

        $user2 = User::find(5);
        $students2 = [
            [
                'student_id' => 'CS002',
                'address' => 'JALAN RUMAH SAYA',
                'name' => $user2->name,
                'phone' => '0129391293',
                'status' => 'active',
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($students2 as $student) {
            $profile  = Student ::create($student);
            $user2->profile()->associate($profile);

            Wallet::create([
                'user_id' => $user2->id,
                'balance' => 50.00,
                'bank_id' => 1,
                'card_number' => '123567812356',
                'card_expiry' => '12/25',
                'card_ccv' => '123',
                'card_holder' => $user2->name,
                'card_type' => 'debit',
            ]);

            $user2->save();
        }
    }
}
