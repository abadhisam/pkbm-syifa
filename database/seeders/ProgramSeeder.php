<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('programs')->insert([
            ['name' => 'Paket A', 'description' => 'Program pendidikan kesetaraan setara Sekolah Dasar (SD).','created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paket B', 'description' => 'Program pendidikan kesetaraan setara Sekolah Menengah Pertama (SMP).','created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paket C IPA', 'description' => 'Program pendidikan kesetaraan setara Sekolah Menengah Atas (SMA) IPA.','created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paket C IPS', 'description' => 'Program pendidikan kesetaraan setara Sekolah Menengah Atas (SMA) IPS.','created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
