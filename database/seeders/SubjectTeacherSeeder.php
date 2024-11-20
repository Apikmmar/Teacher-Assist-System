<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $totalTeacher = User::count();
        
        for ($i=1; $i <= $totalTeacher; $i++) { 
            $assignedSubjects = [];

            while (count($assignedSubjects) < 5) {
                $sub_id = rand(1, 69);
                if (!in_array($sub_id, $assignedSubjects)) {
                    $assignedSubjects[] = $sub_id;

                    DB::table('subject__teachers')->insert([
                        'user_id' => $i,'subject_id' => $sub_id,'created_at' => $now,'updated_at' => $now,
                    ]);
                }
            }
        }
    }
}
