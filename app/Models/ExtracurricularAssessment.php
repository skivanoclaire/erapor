<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtracurricularAssessment extends Model
{
    protected $table = 'extracurricular_assessments';

    // Izinkan mass assignment untuk semua kolom yang dipakai oleh updateOrCreate()
    protected $fillable = [
        'extracurricular_id',
        'semester_id',
        'student_id',
        'mid_grade',
        'mid_description',
        'final_grade',
        'final_description',
    ];

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
