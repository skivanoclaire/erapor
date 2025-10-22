<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CocurricularMember extends Model
{
    protected $table = 'cocurricular_members';
    protected $fillable = ['cocurricular_id','student_id'];
    public function student(){ return $this->belongsTo(Student::class); }
}
