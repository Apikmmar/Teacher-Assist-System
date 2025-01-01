<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('role__users')->insert([
            ['user_id' => 1, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
