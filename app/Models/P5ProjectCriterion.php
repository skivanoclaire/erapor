<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class P5ProjectCriterion extends Model
{
    protected $table = 'p5_project_criteria';
    protected $fillable = ['p5_project_id','order_no','title'];
    public function project(){ return $this->belongsTo(P5Project::class,'p5_project_id'); }
}
