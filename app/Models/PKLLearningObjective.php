<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PKLLearningObjective extends Model
{
    protected $table = 'pkl_learning_objectives';
    protected $fillable = ['school_id','semester_id','class_id','title','description'];
}
