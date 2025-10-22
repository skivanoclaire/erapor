<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CocurricularActivity extends Model
{
    protected $table = 'cocurricular_activities';
    protected $fillable = ['school_id','semester_id','class_id','name','dimension','mentor_id','active'];
    protected $casts = ['active'=>'boolean'];

    public function mentor(){ return $this->belongsTo(User::class,'mentor_id'); }
    public function class(){ return $this->belongsTo(SchoolClass::class,'class_id'); }
    public function semester(){ return $this->belongsTo(Semester::class); }
    public function members(){ return $this->hasMany(CocurricularMember::class,'cocurricular_id'); }
}
