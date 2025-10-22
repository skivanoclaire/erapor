<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReportWaliSignature extends Model
{
    protected $table = 'report_wali_signatures';
    protected $fillable = ['semester_id','class_id','wali_id','signature_media_id'];

    public function semester(){ return $this->belongsTo(Semester::class); }
    public function class(){ return $this->belongsTo(SchoolClass::class,'class_id'); }
    public function wali(){ return $this->belongsTo(User::class,'wali_id'); }
    public function media(){ return $this->belongsTo(MediaUpload::class,'signature_media_id'); }
}
