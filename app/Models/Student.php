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


    public function school(){ return $this->belongsTo(School::class); }
    public function class(){ return $this->belongsTo(SchoolClass::class, 'class_id'); }
}
