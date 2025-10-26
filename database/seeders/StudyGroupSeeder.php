<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyGroupSeeder extends Seeder
{
    public function run(): void
    {
        $group = [
            ['name' => 'AL FAJR'],
            ['name' => 'AL HIKAM'],
            ['name' => 'AL HUDA'],
            ['name' => 'AL IKHLAS'],
            ['name' => 'AL QOLAM'],
            ['name' => 'DARUL SYUHADA'],
            ['name' => 'DQH AMMA'],
            ['name' => 'IBADURRAHMAN'],
            ['name' => 'IBTIDAIYAH IBNU UMAR'],
            ['name' => 'AL BAROKAH'],
            ['name' => 'MANDIRI SYIFA'],
            ['name' => 'MTQ'],
            ['name' => 'PURBALINGGA'],
            ['name' => 'STID AMMA'],
            ['name' => 'STID TABAROK'],
        ];

        DB::table('study_groups')->insert($group);
    }
}
