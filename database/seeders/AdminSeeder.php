<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@edu.com',
            'password' => Hash::make('course2025'),
            'is_admin' => true,
        ]);
    }
}
