<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class P5ProjectStudent extends Model
{
    protected $table = 'p5_project_students';
    protected $fillable = ['p5_project_id','student_id'];
    public function student(){ return $this->belongsTo(Student::class); }
}
