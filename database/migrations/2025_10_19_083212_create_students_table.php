<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('nis', 10)->unique()->nullable();
            $table->string('nisn', 10)->unique()->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->text('address')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->timestamps();
            $table->index('full_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
