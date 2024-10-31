<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Subject_Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubjectTakenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coreSubjects = ['Bahasa Melayu', 'Bahasa Inggeris', 'Pendidikan Islam', 'Matematik', 'Sejarah'];

        $now = now();
        $classes = Classroom::all();

        foreach ($classes as $class) {
            if ($class->form_id <= 3) {
                $this->insertSubjectsForClass($class, Subject::where('form_id', $class->form_id)->get(), $now);
            } else {
                $coreSubjectIds = Subject::where('form_id', $class->form_id)->whereIn('name', $coreSubjects)->get();
                $this->insertSubjectsForClass($class, $coreSubjectIds, $now);

                $additionalSubjects = Subject::where('form_id', $class->form_id)->whereNotIn('name', $coreSubjects)->inRandomOrder()->take(6)->get();
                $this->insertSubjectsForClass($class, $additionalSubjects, $now);
            }
        }
    }

    private function insertSubjectsForClass($class, $subjects, $now)
    {
        foreach ($subjects as $sub) {
            $subsTeacher = Subject_Teacher::where('subject_id', $sub->id)->pluck('id');

            if ($subsTeacher->isNotEmpty()) {
                DB::table('subject__takens')->insert([
                    'student_id' => NULL,'classroom_id' => $class->id,'subject_id' => $sub->id,'subject_teacher_id' => $subsTeacher->isNotEmpty() ? $subsTeacher->random() : NULL, 'remarks' => NULL,'created_at' => $now,'updated_at' => $now
                ]);
            } else {
                Log::warning("No teachers found for subject ID: {$sub->id} in classroom ID: {$class->id}");
            }
        }
    }
}
