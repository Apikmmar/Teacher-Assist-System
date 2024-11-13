<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = now();

        for ($i=1; $i < 8 ; $i++) {
            $strtDate = Carbon::today()->subDays(rand(0, 365));
            $endDate = $strtDate->copy()->addDays(rand(10, 31));
            $releaseDate = $endDate->copy()->addDays(30);
            $status = ['Pending', 'Release'][rand(0, 1)];

            DB::table('examinations')->insert([
                'name' => 'Exam Dummy', 'start_date' => $strtDate, 'end_date' => $endDate, 'status' => $status, 'release_date' => $releaseDate ,'type' => 'Type Dummy', 'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }
}
