<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'petani', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pengepul', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pks', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'refinery', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
