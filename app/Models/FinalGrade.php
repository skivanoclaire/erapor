<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalGrade extends Model
{
    protected $fillable = ['class_subject_id','student_id','final_score','computed_at'];
    protected $casts = ['computed_at'=>'datetime'];
    public function classSubject(){ return $this->belongsTo(ClassSubject::class); }
    public function student(){ return $this->belongsTo(Student::class); }
}
