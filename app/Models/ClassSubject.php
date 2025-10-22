<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subjects';
    protected $fillable = [
        'school_id','semester_id','class_id','subject_id','order_no',
        'teacher_id','combined_with_id','group','active'
    ];
    protected $casts = ['active'=>'boolean'];

    public function school(){ return $this->belongsTo(School::class); }
    public function semester(){ return $this->belongsTo(Semester::class); }
    public function class(){ return $this->belongsTo(SchoolClass::class, 'class_id'); }
    public function subject(){ return $this->belongsTo(Subject::class); }
    public function teacher(){ return $this->belongsTo(User::class, 'teacher_id'); }
    public function combinedWith(){ return $this->belongsTo(self::class, 'combined_with_id'); }
    public function enrollments(){ return $this->hasMany(SubjectEnrollment::class); }
    public function assessments(){ return $this->hasMany(Assessment::class); }
    public function finalGrades(){ return $this->hasMany(FinalGrade::class); }
}
