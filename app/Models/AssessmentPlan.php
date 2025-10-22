<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentPlan extends Model
{
    protected $fillable = [
    'class_subject_id',
    'planned_formatif', 'planned_sumatif', 'planned_sumatif_as',
    'weight_formatif', 'weight_sumatif', 'weight_sumatif_as',
];

    public function classSubject(){ return $this->belongsTo(ClassSubject::class); }
}
