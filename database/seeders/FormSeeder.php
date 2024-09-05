<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('forms')->insert([
            ['name' => 'Form 1', 'total_class' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Form 2', 'total_class' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Form 3', 'total_class' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Form 4', 'total_class' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Form 5', 'total_class' => '5', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
