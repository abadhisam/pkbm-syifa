<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('document_type', ['Ijazah Terakhir', 'Kartu Keluarga', 'Akte Kelahiran', 'Transkrip Nilai', 'Foto Diri', 'Formulir Pendaftaran', 'Raport']);
            $table->string('file_path', 255);
            $table->timestamps();
            
            $table->unique(['student_id', 'document_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_documents');
    }
};
