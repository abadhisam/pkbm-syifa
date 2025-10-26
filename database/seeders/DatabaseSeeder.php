<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // StudentSeeder::class,
            AcademicYearSeeder::class,
            ProgramSeeder::class,
            StudyGroupSeeder::class,
            // EnrollmentSeeder::class
        ]);
    }
}
