<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PKLAssessment extends Model
{
    protected $table = 'pkl_assessments';
    protected $fillable = ['pkl_group_id','student_id','grade','description'];
}
