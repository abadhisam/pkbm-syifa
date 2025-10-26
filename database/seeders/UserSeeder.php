<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'super admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
        
        DB::table('users')->insert([
            'name' => 'admin 1',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        DB::table('users')->insert([
            'name' => 'admin 2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
