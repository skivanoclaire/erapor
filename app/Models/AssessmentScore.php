<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentScore extends Model
{
    protected $fillable = ['assessment_id','student_id','score','note'];
    public function assessment(){ return $this->belongsTo(Assessment::class); }
    public function student(){ return $this->belongsTo(Student::class); }
}
