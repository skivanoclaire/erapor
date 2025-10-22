<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PKLGroup extends Model
{
    protected $table = 'pkl_groups';
    protected $fillable = [
        'school_id','semester_id','class_id','sk_penugasan','tempat_pkl',
        'pembimbing_id','learning_objective_id','started_at','ended_at'
    ];
    protected $casts = ['started_at'=>'date','ended_at'=>'date'];

    public function mentor(){ return $this->belongsTo(User::class,'pembimbing_id'); }
    public function class(){ return $this->belongsTo(SchoolClass::class,'class_id'); }
    public function semester(){ return $this->belongsTo(Semester::class); }
    public function objective(){ return $this->belongsTo(PKLLearningObjective::class,'learning_objective_id'); }
}
