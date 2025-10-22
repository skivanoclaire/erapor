<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'school_id','semester_id','class_id','student_id',
        'promoted','next_class_id','note','decided_at'
    ];
    protected $casts = ['promoted'=>'boolean','decided_at'=>'datetime'];
}
