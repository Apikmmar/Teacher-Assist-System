<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        for ($i=0; $i < 50; $i++) { 
            $randomDOB = Carbon::create(rand(2007, 2011), rand(1, 12), rand(1, 28));
            $randomJSD = Carbon::create(rand(2019, 2024), 1, 1);
            
            $stdID = 'ST'.rand(1111, 9999);
            $icFormat = $randomDOB->format('ymd') . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $randName = Arr::random(['Sarah', 'Lisa', 'Hakeem', 'Johnny', 'Dzul', 'Kimi']);
            $randGender = Arr::random(['Men', 'Women']);
            $status = Arr::random(['Active', 'Inactive']);

            if ($status == 'Active') {
                $class_id = (rand(0, 1) === 0) ? NULL : rand(1, 5);
            } else {
                $class_id = NULL;
            }
            
            DB::table('students')->insert([
                ['classroom_id' => NULL, 'student_id' => $stdID, 'name' => $randName, 'ic' => $icFormat, 'gender' => $randGender, 'dob' => $randomDOB, 'join_school_date' => $randomJSD, 'status' => $status, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
