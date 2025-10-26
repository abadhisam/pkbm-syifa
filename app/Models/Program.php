<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'description'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'program_id');
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'program_id', 'student_id');
    }
}
