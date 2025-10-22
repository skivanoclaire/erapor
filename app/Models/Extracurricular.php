<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = ['school_id','name','mentor_id','active'];
    protected $casts = ['active'=>'boolean'];

    public function mentor(){ return $this->belongsTo(User::class,'mentor_id'); }
        public function members()
    {
        return $this->hasMany(ExtracurricularMember::class, 'extracurricular_id');
    }
    public function assessments()
    {
        return $this->hasMany(ExtracurricularAssessment::class, 'extracurricular_id');
    }
}
