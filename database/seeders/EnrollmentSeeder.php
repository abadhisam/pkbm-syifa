<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        $studentCount = DB::table('students')->count();
        
        if ($studentCount < 15) {
            $this->command->error('❌ Error: Students table harus memiliki minimal 15 data!');
            $this->command->error('Jalankan StudentSeeder terlebih dahulu: php artisan db:seed --class=StudentSeeder');
            return;
        }

        $academicYearId = DB::table('academic_years')->where('is_active', true)->value('id');
        $programIds = DB::table('programs')->pluck('id')->toArray();
        $studyGroupIds = DB::table('study_groups')->pluck('id')->toArray();
        
        if (!$academicYearId || empty($programIds) || empty($studyGroupIds)) {
            $this->command->error('❌ Error: Pastikan data AcademicYear, Program, dan StudyGroup sudah ada!');
            return;
        }

        $studentIds = DB::table('students')->pluck('id')->toArray();
        $now = Carbon::now();

        $programStudyGroupMap = [
            1 => array_slice($studyGroupIds, 0, 5),
            2 => array_slice($studyGroupIds, 5, 5),
            3 => array_slice($studyGroupIds, 10, 4),
        ];
        
        $enrollments = [];
        $fixedEnrollments = [
            [
                'student_id' => $studentIds[0],
                'program_id' => 1,
                'origin_school' => 'SD Negeri 1 Madiun',
                'graduation_year' => 2024,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[1],
                'program_id' => 1,
                'origin_school' => 'SD Muhammadiyah Madiun',
                'graduation_year' => 2023,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[2],
                'program_id' => 1,
                'origin_school' => 'SD Negeri 2 Madiun',
                'graduation_year' => 2024,
                'status' => 'Aktif',
            ],
            
            [
                'student_id' => $studentIds[3],
                'program_id' => 2,
                'origin_school' => 'SMP Negeri 1 Madiun',
                'graduation_year' => 2024,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[4],
                'program_id' => 2,
                'origin_school' => 'SMP Islam Al-Azhar Madiun',
                'graduation_year' => 2023,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[5],
                'program_id' => 2,
                'origin_school' => 'SMP Negeri 3 Madiun',
                'graduation_year' => 2024,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[6],
                'program_id' => 2,
                'origin_school' => 'MTs Negeri Madiun',
                'graduation_year' => 2022,
                'status' => 'Aktif',
            ],
            
            [
                'student_id' => $studentIds[7],
                'program_id' => 3,
                'origin_school' => 'SMA Negeri 1 Madiun',
                'graduation_year' => 2024,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[8],
                'program_id' => 3,
                'origin_school' => 'SMA Katolik Madiun',
                'graduation_year' => 2023,
                'status' => 'Aktif',
            ],
            [
                'student_id' => $studentIds[9],
                'program_id' => 3,
                'origin_school' => 'MA Negeri 1 Madiun',
                'graduation_year' => 2024,
                'status' => 'Aktif',
            ],
        ];

        foreach ($fixedEnrollments as $enrollment) {
            $programId = $enrollment['program_id'];
            $availableGroups = $programStudyGroupMap[$programId] ?? $studyGroupIds;
            
            $enrollments[] = array_merge($enrollment, [
                'academic_year_id' => $academicYearId,
                'study_group_id' => $availableGroups[array_rand($availableGroups)],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (count($studentIds) >= 15) {
            $originSchools = [
                1 => ['SD Negeri 3 Madiun', 'SD Al-Irsyad', 'MI Madiun', null],
                2 => ['SMP Negeri 2 Madiun', 'SMP IT Madiun', 'MTs Swasta Madiun', null],
                3 => ['SMA Negeri 2 Madiun', 'SMA Swasta Madiun', 'SMK Negeri 1 Madiun', null],
            ];
            
            $statuses = ['Aktif', 'Alumni', 'Tidak Selesai'];
            
            for ($i = 10; $i < 15; $i++) {
                $programId = rand(1, 3);
                $availableGroups = $programStudyGroupMap[$programId] ?? $studyGroupIds;
                $status = $statuses[array_rand($statuses)];
                
                $enrollments[] = [
                    'student_id' => $studentIds[$i],
                    'academic_year_id' => $academicYearId,
                    'program_id' => $programId,
                    'study_group_id' => $availableGroups[array_rand($availableGroups)],
                    'origin_school' => $originSchools[$programId][array_rand($originSchools[$programId])],
                    'graduation_year' => rand(0, 1) ? rand(2020, 2024) : null,
                    'status' => $status,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

         try {
            DB::table('enrollments')->insert($enrollments);
            $this->command->info('✅ Enrollments seeded successfully!');
            $this->command->info('📊 Total enrollments: ' . count($enrollments));
            
            $activeCount = collect($enrollments)->where('status', 'Aktif')->count();
            $alumniCount = collect($enrollments)->where('status', 'Alumni')->count();
            $notFinishedCount = collect($enrollments)->where('status', 'Tidak Selesai')->count();
            
            $this->command->info("   - Aktif: {$activeCount}");
            $this->command->info("   - Alumni: {$alumniCount}");
            $this->command->info("   - Tidak Selesai: {$notFinishedCount}");
            
        } catch (\Exception $e) {
            $this->command->error('❌ Error saat seeding enrollments: ' . $e->getMessage());
        }
    }
}