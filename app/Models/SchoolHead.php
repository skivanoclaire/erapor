<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolHead extends Model
{
    protected $fillable = ['school_id','nip','gelar_depan','nama','gelar_belakang'];
    public function school(){ return $this->belongsTo(School::class); }
    public function getNamaLengkapAttribute(): string
    {
        $d = trim(($this->gelar_depan ? $this->gelar_depan.' ' : '').($this->nama ?? ''));
        if (!empty($this->gelar_belakang)) {
            $d .= ', '.$this->gelar_belakang;
        }
        // rapikan spasi ganda
        return trim(preg_replace('/\s+/', ' ', $d));
    }
}
