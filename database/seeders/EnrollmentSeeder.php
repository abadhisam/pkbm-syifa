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

        if ($studentCount < 197) {
            $this->command->warn('⚠️  Warning: Diharapkan 197 students, saat ini ada ' . $studentCount);
        }

        $academicYearId = DB::table('academic_years')->where('is_active', true)->value('id');
        $programs = DB::table('programs')->get()->keyBy('name');
        $studyGroupIds = DB::table('study_groups')->pluck('id')->toArray();

        if (!$academicYearId || $programs->isEmpty() || empty($studyGroupIds)) {
            $this->command->error('❌ Error: Pastikan data AcademicYear, Program, dan StudyGroup sudah ada!');
            return;
        }

        $requiredPrograms = ['Paket A', 'Paket B', 'Paket C IPA', 'Paket C IPS'];
        foreach ($requiredPrograms as $programName) {
            if (!$programs->has($programName)) {
                $this->command->error("❌ Error: Program '{$programName}' tidak ditemukan!");
                $this->command->error('Pastikan tabel programs memiliki: Paket A, Paket B, Paket C IPA, Paket C IPS');
                return;
            }
        }

        $students = DB::table('students')->orderBy('id')->get();
        $now = Carbon::now();

        $programStudyGroupMap = [
            $programs['Paket A']->id => [1, 2, 3, 4, 5],
            $programs['Paket B']->id => [6, 7, 8, 9],
            $programs['Paket C IPA']->id => [10, 11, 12],
            $programs['Paket C IPS']->id => [13, 14, 15],
        ];

        $statuses = ['Aktif', 'Alumni', 'Tidak Selesai'];
        $enrollments = [];

        foreach ($students as $student) {
            $programId = null;

            if (strpos($student->nis, 'A-') === 0) {
                $programId = $programs['Paket A']->id;
            } elseif (strpos($student->nis, 'B-') === 0) {
                $programId = $programs['Paket B']->id;
            } elseif (strpos($student->nis, 'C-') === 0) {
                $nisNumber = (int) str_replace('C-', '', $student->nis);

                if ($nisNumber >= 412 && $nisNumber <= 461) {
                    $programId = $programs['Paket C IPS']->id;
                } elseif ($nisNumber >= 462 && $nisNumber <= 501) {
                    $programId = $programs['Paket C IPA']->id;
                } else {
                    $programId = $programs['Paket C IPS']->id;
                }
            }

            if (!$programId) {
                $this->command->warn("⚠️  Student {$student->nis} tidak bisa ditentukan programnya, skip.");
                continue;
            }

            $availableGroups = $programStudyGroupMap[$programId] ?? $studyGroupIds;
            $studyGroupId = $availableGroups[array_rand($availableGroups)];

            $rand = rand(1, 100);
            if ($rand <= 80) {
                $status = 'Aktif';
            } elseif ($rand <= 95) {
                $status = 'Alumni';
            } else {
                $status = 'Tidak Selesai';
            }

            $graduationYear = null;
            if ($status === 'Alumni') {
                $graduationYear = rand(2020, 2023);
            } elseif ($status === 'Aktif') {
                if (rand(1, 100) <= 70) {
                    $graduationYear = rand(2024, 2026);
                }
            }

            $enrollments[] = [
                'student_id' => $student->id,
                'academic_year_id' => $academicYearId,
                'program_id' => $programId,
                'study_group_id' => $studyGroupId,
                'graduation_year' => $graduationYear,
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        try {
            $chunks = array_chunk($enrollments, 50);
            foreach ($chunks as $chunk) {
                DB::table('enrollments')->insert($chunk);
            }

            $this->command->info('✅ Enrollments seeded successfully!');
            $this->command->info('📊 Total enrollments: ' . count($enrollments));

            $activeCount = collect($enrollments)->where('status', 'Aktif')->count();
            $alumniCount = collect($enrollments)->where('status', 'Alumni')->count();
            $notFinishedCount = collect($enrollments)->where('status', 'Tidak Selesai')->count();

            $paketACount = collect($enrollments)->where('program_id', $programs['Paket A']->id)->count();
            $paketBCount = collect($enrollments)->where('program_id', $programs['Paket B']->id)->count();
            $paketCIPACount = collect($enrollments)->where('program_id', $programs['Paket C IPA']->id)->count();
            $paketCIPSCount = collect($enrollments)->where('program_id', $programs['Paket C IPS']->id)->count();

            $this->command->info('');
            $this->command->info('📈 Status Distribution:');
            $this->command->info("   - Aktif: {$activeCount}");
            $this->command->info("   - Alumni: {$alumniCount}");
            $this->command->info("   - Tidak Selesai: {$notFinishedCount}");

            $this->command->info('');
            $this->command->info('📚 Program Distribution:');
            $this->command->info("   - Paket A: {$paketACount}");
            $this->command->info("   - Paket B: {$paketBCount}");
            $this->command->info("   - Paket C IPA: {$paketCIPACount}");
            $this->command->info("   - Paket C IPS: {$paketCIPSCount}");

        } catch (\Exception $e) {
            $this->command->error('❌ Error saat seeding enrollments: ' . $e->getMessage());
            $this->command->error($e->getTraceAsString());
        }
    }
}
