<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
    'school_id','class_id','nama','jk','tanggal_lahir','nis','nisn','nik',
    'tempat_lahir','agama','status_dalam_keluarga','anak_ke',
    'nomor_rumah','nomor_hp','alamat',
    'berat_badan','tinggi_badan',
    'sekolah_asal','tanggal_masuk_sekolah','diterima_di_kelas',
    'nama_ayah','pekerjaan_ayah','nama_ibu','pekerjaan_ibu','telepon_rumah','alamat_orang_tua',
    'nama_wali','pekerjaan_wali','telepon_wali','alamat_wali',
    ];

    protected static function booted()
    {
        static::deleting(function ($student) {
            // Hapus semua data yang berelasi dengan student
            \DB::table('assessment_scores')->where('student_id', $student->id)->delete();
            \DB::table('final_grades')->where('student_id', $student->id)->delete();
            \DB::table('subject_enrollments')->where('student_id', $student->id)->delete();
            \DB::table('attendances')->where('student_id', $student->id)->delete();
            \DB::table('notes')->where('student_id', $student->id)->delete();
            \DB::table('promotions')->where('student_id', $student->id)->delete();
            \DB::table('p5_project_students')->where('student_id', $student->id)->delete();
            \DB::table('p5_project_ratings')->where('student_id', $student->id)->delete();
            \DB::table('extracurricular_members')->where('student_id', $student->id)->delete();
            \DB::table('extracurricular_assessments')->where('student_id', $student->id)->delete();
            \DB::table('pkl_group_members')->where('student_id', $student->id)->delete();
            \DB::table('pkl_assessments')->where('student_id', $student->id)->delete();
            \DB::table('cocurricular_members')->where('student_id', $student->id)->delete();
            \DB::table('cocurricular_assessments')->where('student_id', $student->id)->delete();
        });
    }

    public function school(){ return $this->belongsTo(School::class); }
    public function class(){ return $this->belongsTo(SchoolClass::class, 'class_id'); }
}
