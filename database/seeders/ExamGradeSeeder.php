<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = now();

        for ($i=1; $i <= 3; $i++) { 
            DB::table('examination__grades')->insert([
                ['form_id' => $i, 'grade' => 'A', 'mark_min' => 82, 'mark_max' => 100, 'grade_value' => 4.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'B', 'mark_min' => 66, 'mark_max' => 81, 'grade_value' => 3.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'C', 'mark_min' => 50, 'mark_max' => 65, 'grade_value' => 2.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'D', 'mark_min' => 35, 'mark_max' => 49, 'grade_value' => 1.50, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'E', 'mark_min' => 20, 'mark_max' => 34, 'grade_value' => 1.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'F', 'mark_min' => 0, 'mark_max' => 19, 'grade_value' => 0.00, 'is_passed' => 'failed', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        for ($i=4; $i <= 5; $i++) { 
            DB::table('examination__grades')->insert([
                ['form_id' => $i, 'grade' => 'A+', 'mark_min' => 90, 'mark_max' => 100, 'grade_value' => 4.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'A', 'mark_min' => 80, 'mark_max' => 90, 'grade_value' => 3.67, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'A-', 'mark_min' => 70, 'mark_max' => 79, 'grade_value' => 3.33, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'B+', 'mark_min' => 65, 'mark_max' => 69, 'grade_value' => 3.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'B', 'mark_min' => 60, 'mark_max' => 64, 'grade_value' => 2.67, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'C+', 'mark_min' => 55, 'mark_max' => 59, 'grade_value' => 2.50, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'C', 'mark_min' => 50, 'mark_max' => 54, 'grade_value' => 2.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'D', 'mark_min' => 45, 'mark_max' => 49, 'grade_value' => 1.50, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'E', 'mark_min' => 40, 'mark_max' => 44, 'grade_value' => 1.00, 'is_passed' => 'passed', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'grade' => 'F', 'mark_min' => 0, 'mark_max' => 39, 'grade_value' => 0.00, 'is_passed' => 'failed', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
