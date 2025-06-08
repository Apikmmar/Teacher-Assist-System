<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            ['teacher_id' => 'TC02011', 'name' => 'afiq ammar', 'ic' => '990807023467', 'gender' => 'Men', 'contact' => '0107730425', 'email' => 'apikammar07@gmail.com', 'password' => Hash::make('password1234'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC11111', 'name' => 'afiq', 'ic' => '111111111111', 'gender' => 'Men', 'contact' => '1234567890', 'email' => 'afiq@gmail.com', 'password' => Hash::make('password1234'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC22222', 'name' => 'afiqah', 'ic' => '222222222222', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'afiqah@gmail.com', 'password' => Hash::make('password1234'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC33333', 'name' => 'amar', 'ic' => '333333333333', 'gender' => 'Men', 'contact' => '1234567890', 'email' => 'amar@gmail.com', 'password' => Hash::make('password1234'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC44444', 'name' => 'amirah', 'ic' => '44444444444', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'amirah@gmail.com', 'password' => Hash::make('password1234'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC55555', 'name' => 'james', 'ic' => '555555555555', 'gender' => 'Men', 'contact' => '1234567890', 'email' => 'james@gmail.com', 'password' => Hash::make('password1234'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
