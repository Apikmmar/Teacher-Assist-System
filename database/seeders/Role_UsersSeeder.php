<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Role_UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('role__users')->insert([
            ['user_id' => 1, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 1, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],

            ['user_id' => 2, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            
            ['user_id' => 3, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],

            ['user_id' => 4, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],

            ['user_id' => 5, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 5, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            
            ['user_id' => 6, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 6, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            
            ['user_id' => 7, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 7, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],

            ['user_id' => 8, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
