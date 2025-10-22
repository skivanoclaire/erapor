<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P5Project extends Model
{
    protected $table = 'p5_projects';
    protected $fillable = ['school_id','semester_id','class_id','theme','subelement_count','mentor_id','active'];
    protected $casts = ['active'=>'boolean'];

    public function class(){ return $this->belongsTo(SchoolClass::class,'class_id'); }
    public function semester(){ return $this->belongsTo(Semester::class); }
    public function mentor(){ return $this->belongsTo(User::class,'mentor_id'); }
    public function members(){ return $this->hasMany(P5ProjectStudent::class,'p5_project_id'); }
    public function criteria(){ return $this->hasMany(P5ProjectCriterion::class,'p5_project_id')->orderBy('order_no'); }
}
