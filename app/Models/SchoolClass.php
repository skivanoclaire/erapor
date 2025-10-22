<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    protected $fillable = ['school_id','nama_kelas','jurusan','tingkat_pendidikan','wali_kelas_id'];

    public function school(){ return $this->belongsTo(School::class); }
    public function wali(){ return $this->belongsTo(User::class, 'wali_kelas_id'); }
    public function students(){ return $this->hasMany(Student::class, 'class_id'); }
}
