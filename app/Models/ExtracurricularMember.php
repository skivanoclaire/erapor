<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtracurricularMember extends Model
{
    protected $table = 'extracurricular_members';

    // 👉 izinkan kolom-kolom ini
    protected $fillable = [
        'extracurricular_id', 'semester_id', 'student_id',
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
