<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PKLGroupMember extends Model
{
    protected $table = 'pkl_group_members';
    protected $fillable = ['pkl_group_id','student_id'];
    public function student(){ return $this->belongsTo(Student::class); }
}
