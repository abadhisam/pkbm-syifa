<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('academic_years')->insert([
            ['name' => '2021/2022','is_active' => false],
            ['name' => '2022/2023','is_active' => false],
            ['name' => '2023/2024','is_active' => false],
            ['name' => '2024/2025','is_active' => false],
            ['name' => '2025/2026','is_active' => true],
            ['name' => '2026/2027','is_active' => false],
        ]);
    }
}
