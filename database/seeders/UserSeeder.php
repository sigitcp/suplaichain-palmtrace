<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'superadmin',
                'password' => Hash::make('admin'),
                'phone'    => '081234567890',
                'role_id'  => 1, // admin
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'petani',
                'password' => Hash::make('petani'),
                'phone'    => '081234567891',
                'role_id'  => 2, // petani
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'pengepul',
                'password' => Hash::make('pengepul'),
                'phone'    => '081234567892',
                'role_id'  => 3, // pengepul
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
