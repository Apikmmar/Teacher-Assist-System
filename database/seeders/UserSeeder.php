<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            ['teacher_id' => 'TC11111', 'name' => 'afiq ammar', 'ic' => '020111020425', 'gender' => 'Men', 'contact' => '0107730425', 'email' => 'apikammar07@gmail.com', 'password' => Hash::make('020111020425'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC11111', 'name' => 'afiq', 'ic' => '111111111111', 'gender' => 'Men', 'contact' => '1234567890', 'email' => 'afiq@gmail.com', 'password' => Hash::make('111111111111'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC22222', 'name' => 'afiqah', 'ic' => '222222222222', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'afiqah@gmail.com', 'password' => Hash::make('222222222222'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC33333', 'name' => 'amar', 'ic' => '333333333333', 'gender' => 'Men', 'contact' => '1234567890', 'email' => 'amar@gmail.com', 'password' => Hash::make('333333333333'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC44444', 'name' => 'amirah', 'ic' => '44444444444', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'amirah@gmail.com', 'password' => Hash::make('44444444444'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC55555', 'name' => 'james', 'ic' => '555555555555', 'gender' => 'Men', 'contact' => '1234567890', 'email' => 'james@gmail.com', 'password' => Hash::make('555555555555'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC66666', 'name' => 'jasmine', 'ic' => '666666666666', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'jasmine@gmail.com', 'password' => Hash::make('666666666666'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC77777', 'name' => 'lily', 'ic' => '777777777777', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'lily@gmail.com', 'password' => Hash::make('777777777777'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC88888', 'name' => 'rose', 'ic' => '888888888888', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'rose@gmail.com', 'password' => Hash::make('888888888888'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['teacher_id' => 'TC99999', 'name' => 'daisy', 'ic' => '999999999999', 'gender' => 'Women', 'contact' => '1234567890', 'email' => 'daisy@gmail.com', 'password' => Hash::make('999999999999'), 'verification' => 'teacher_verification.pdf', 'photo' => NULL, 'created_at' => $now, 'updated_at' => $now],
            
        ]);
    }
}
