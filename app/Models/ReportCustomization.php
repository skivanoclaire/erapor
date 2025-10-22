<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReportCustomization extends Model
{
    protected $table = 'report_customizations';
    protected $fillable = [
        'school_id','apply_to','font_family',
        'title_font_size','table_header_font_size','table_body_font_size'
    ];
    protected $casts = [
        'title_font_size'=>'decimal:1',
        'table_header_font_size'=>'decimal:1',
        'table_body_font_size'=>'decimal:1',
    ];

    public function school(){ return $this->belongsTo(School::class); }
}
