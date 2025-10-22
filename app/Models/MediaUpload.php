<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MediaUpload extends Model
{
    protected $fillable = ['school_id','path','mime','size'];
    public function school(){ return $this->belongsTo(School::class); }

    // helper
    public function url(): string { return asset('storage/'.$this->path); }
    public function filename(): string { return basename($this->path); }
}
