<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('restrict');
            $table->foreignId('program_id')->constrained('programs')->onDelete('restrict');
            $table->foreignId('study_group_id')->nullable()->constrained('study_groups')->nullOnDelete();
            
            $table->year('graduation_year')->nullable();
            $table->enum('status', ['Aktif', 'Alumni', 'Tidak Selesai'])->default('Aktif');

            $table->timestamps();
            $table->unique(['student_id', 'academic_year_id', 'program_id']);
            $table->index('program_id'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
