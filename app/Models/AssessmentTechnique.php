<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentTechnique extends Model
{
    protected $fillable = ['school_id','name','short_name'];
    public function school(){ return $this->belongsTo(School::class); }
}
