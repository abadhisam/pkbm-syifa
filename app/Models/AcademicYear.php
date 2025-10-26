<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_active'];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'academic_year_id');
    }
}
