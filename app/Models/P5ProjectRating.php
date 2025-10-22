<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class P5ProjectRating extends Model
{
    protected $table = 'p5_project_ratings';
    protected $fillable = ['p5_project_id','criterion_id','student_id','level','description'];
    public function criterion(){ return $this->belongsTo(P5ProjectCriterion::class,'criterion_id'); }
    public function student(){ return $this->belongsTo(Student::class); }
}
