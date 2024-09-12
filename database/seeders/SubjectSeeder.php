<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        for ($i=1; $i <= 3 ; $i++) { 
            DB::table('subjects')->insert([
                ['form_id' => $i, 'name' => 'Bahasa Melayu', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Bahasa Inggeris', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Bahasa Arab', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Sains', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Matematik', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Sejarah', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Geografi', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Reka Bentuk & Teknologi', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Reka Jasmani & Kesihatan', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Pendidikan Islam', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Pendidikan Seni Visual', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
            ]);
        };

        for ($i=4 ; $i <= 5; $i++) { 
            DB::table('subjects')->insert([
                ['form_id' => $i, 'name' => 'Bahasa Melayu', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Bahasa Inggeris', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Pendidikan Islam', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Matematik', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Sejarah', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],

                ['form_id' => $i, 'name' => 'Matematik Tambahan', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Fizik', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Kimia', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Biologi', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Sains Komputer', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Grafik Komunikasi Teknikal', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Geografi', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Pendidikan Seni Visual', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Sains', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Akaun', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Perniagaan', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Pendidikan Al-Quran dan Sunnah', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
                ['form_id' => $i, 'name' => 'Pendidikan Syariah Islamiah', 'description' => 'N/A', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
