<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'academic_year_id', 'program_id', 
        'graduation_year', 'status', 'study_group_id'
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function studyGroup()
    {
        return $this->belongsTo(StudyGroup::class);
    }
}
