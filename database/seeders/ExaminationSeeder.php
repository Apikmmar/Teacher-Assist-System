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

        for ($i=1; $i <= 4 ; $i++) {
            $strtDate = Carbon::today()->subDays(rand(0, 365));
            $endDate = $strtDate->copy()->addDays(rand(10, 31));
            $releaseDate = $endDate->copy()->addDays(30);
            $status = ['Pending', 'Release'][rand(0, 1)];
            $examStatus = ['Peperiksaan Awal Tahun', 'Peperiksaan Pertengahan Tahun', 'Peperiksaan Akhir Tahun'][rand(0, 2)];

            DB::table('examinations')->insert([
                'name' => $examStatus.' '.$strtDate->year, 'start_date' => $strtDate, 'end_date' => $endDate, 'status' => $status, 'release_date' => $releaseDate ,'type' => $examStatus, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }
}
