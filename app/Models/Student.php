<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name', 'nis', 'nisn',
        'gender', 'address', 'phone_number',
    ];

    public const REQUIRED_DOCUMENTS = [
        'Ijazah Terakhir',
        'KK',
        'Akte Kelahiran',
        'Transkrip Nilai',
        'Foto Diri',
        'Raport',
        'Formulir Pendaftaran'
    ];

    protected $appends = ['missing_documents'];

    public function documents()
    {
        return $this->hasMany(StudentDocument::class, 'student_id');
    }

    public function getMissingDocumentsAttribute(): array
    {
        $have = $this->documents()->pluck('document_type')->all();
        return array_values(array_diff(self::REQUIRED_DOCUMENTS, $have));
    }

    public function hasCompleteDocuments(): bool
    {
        return count($this->missing_documents) === 0;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function activeEnrollment()
    {
        return $this->hasOne(Enrollment::class)
            ->where('status', 'Aktif')
            ->whereHas('academicYear', fn($q) => $q->where('is_active', true));
    }

    public function scopeByAcademicYear($query, $academicYearId)
    {
        return $query->whereHas('enrollments', function ($q) use ($academicYearId) {
            $q->where('academic_year_id', $academicYearId);
        });
    }

    public function scopeByProgram($query, $programId)
    {
        return $query->whereHas('enrollments', function ($q) use ($programId) {
            $q->where('program_id', $programId);
        });
    }

    public function scopeByStudyGroup($query, $studyGroupId)
    {
        return $query->whereHas('enrollments', function ($q) use ($studyGroupId) {
            $q->where('study_group_id', $studyGroupId);
        });
    }

    public function scopeByStatus($query, $status)
    {
        return $query->whereHas('enrollments', function ($q) use ($status) {
            $q->where('status', $status);
        });
    }
}
