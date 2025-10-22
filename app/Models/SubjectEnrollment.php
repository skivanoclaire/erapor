<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectEnrollment extends Model
{
    protected $fillable = [
        'school_id','semester_id','class_id',
        'class_subject_id','student_id','participates'
    ];
    protected $casts = ['participates'=>'boolean'];

    public function classSubject(){ return $this->belongsTo(ClassSubject::class); }
    public function student(){ return $this->belongsTo(Student::class); }
}
