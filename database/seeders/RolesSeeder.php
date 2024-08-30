<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('roles')->insert([
            ['name' => 'Class Teacher', 'role_description' => 'Teacher that in charge for the classroom', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Management', 'role_description' => 'Top management of school include GK, PK and Headmaster', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Coordinator', 'role_description' => 'Admin of the system and in charge for managing the examination', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
