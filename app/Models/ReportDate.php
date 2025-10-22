<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReportDate extends Model
{
    protected $table = 'report_dates';
    protected $fillable = ['semester_id','class_id','mid_report_date','final_report_date'];
    protected $casts = ['mid_report_date'=>'date','final_report_date'=>'date'];

    public function semester(){ return $this->belongsTo(Semester::class); }
    public function class(){ return $this->belongsTo(SchoolClass::class,'class_id'); }
}
