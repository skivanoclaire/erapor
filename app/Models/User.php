<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'school_id','username','password','nik','nip','gelar_depan','nama',
        'gelar_belakang','jenis_ptk','ptk_aktif','remember_token'
    ];

    protected $hidden = ['password','remember_token'];
    protected $casts = ['ptk_aktif'=>'boolean'];

    public function school(){ return $this->belongsTo(School::class); }
    public function homeroomOf(){ return $this->hasMany(SchoolClass::class, 'wali_kelas_id'); }
}
