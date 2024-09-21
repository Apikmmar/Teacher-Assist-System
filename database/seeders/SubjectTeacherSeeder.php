<?php

namespace Database\Seeders;

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
        
        for ($i=1; $i <= 40; $i++) { 
            for ($j=1; $j <= 4; $j++) { 
                $sub_id = rand(1, 69);
                DB::table('subject__teachers')->insert([
                    ['user_id' => $i, 'subject_id' => $sub_id, 'created_at' => $now, 'updated_at' => $now],
                ]);
            }
        }
    }
}
