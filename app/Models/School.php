<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'jenjang','npsn','nss','nama_sekolah','alamat_jalan','desa_kelurahan',
        'kecamatan','kabupaten_kota','provinsi','kode_pos','telepon','fax','website','email'
    ];

    public function head()     { return $this->hasOne(SchoolHead::class); }
    public function semesters(){ return $this->hasMany(Semester::class); }
}
