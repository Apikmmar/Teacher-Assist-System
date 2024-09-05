<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('classrooms')->insert([
            ['form_id' => 1, 'classteacher_id' => 6, 'name' => '1 PKR', 'num_student' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['form_id' => 2, 'classteacher_id' => 7, 'name' => '2 DAP', 'num_student' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['form_id' => 3, 'classteacher_id' => 8, 'name' => '3 AMANAH', 'num_student' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['form_id' => 4, 'classteacher_id' => 9, 'name' => '4 UMNO', 'num_student' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['form_id' => 5, 'classteacher_id' => 10, 'name' => '5 MCA', 'num_student' => '5', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
