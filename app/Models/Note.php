<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['student_id','semester_id','catatan_tengah','catatan_akhir'];
}
