<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            RolesSeeder::class,
            Role_UsersSeeder::class,
            FormSeeder::class,
            ClassroomSeeder::class,
            StudentsSeeder::class,
            SubjectSeeder::class,
            SubjectTeacherSeeder::class,
            SubjectTakenSeeder::class,
            ExaminationSeeder::class,
            ExamGradeSeeder::class,
        ]);
    }
}
