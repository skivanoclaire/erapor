<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'class_subject_id','technique_id','type','title','date','max_score','weight'
    ];
    protected $casts = ['date'=>'date'];

        public function scopeType($q, string $type) {
        return $q->where('type',$type); // formatif|sumatif|sumatif_as
    }
    public function classSubject(){ return $this->belongsTo(ClassSubject::class); }
    public function technique(){ return $this->belongsTo(AssessmentTechnique::class,'technique_id'); }
    public function scores(){ return $this->hasMany(AssessmentScore::class); }
}
