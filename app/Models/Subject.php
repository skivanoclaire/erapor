<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name','short_name','group','global_active'];
    protected $casts = ['global_active'=>'boolean'];

    public function classSubjects(){ return $this->hasMany(ClassSubject::class); }
}
