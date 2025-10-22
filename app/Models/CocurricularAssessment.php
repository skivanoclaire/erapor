<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CocurricularAssessment extends Model
{
    protected $table = 'cocurricular_assessments';
    protected $fillable = ['cocurricular_id','student_id','grade','description'];
}
