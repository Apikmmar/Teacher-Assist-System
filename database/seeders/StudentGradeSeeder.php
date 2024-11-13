<?php

namespace Database\Seeders;

use App\Models\Examination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = now();
        $grades = [
            'A' => 4.00,
            'B' => 3.00,
            'C' => 2.00,
            'D' => 1.50,
            'E' => 1.00,
            'F' => 0.00,
        ];

        foreach (Examination::all() as $exam) {
            for ($j=1; $j <= 10; $j++) { 
                for ($k=1; $k <= 30; $k++) { 
                    $mark = rand(0, 100);
                    $grade = array_rand($grades);
                    $grade_value = $grades[$grade];
                    $is_passed = $grade_value >= 2.00 ? 'passed' : 'failed';
                
                    DB::table('student__grades')->insert([
                        'examination_id' => $exam->id, 'subject_id' => $j, 'student_id' => $k, 'grade' => $grade, 'marks' => $mark, 'grade_value' => $grade_value, 'is_passed' => $is_passed, 'feedback' => '', 'created_at' => $now, 'updated_at' => $now,
                    ]);
                }
            }
        }
    }
}
