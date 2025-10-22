<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class P5ProjectCriterion extends Model
{
    protected $table = 'p5_project_criteria';
    protected $fillable = ['p5_project_id','order_no','title','dimension_id'];

    public function project(){ return $this->belongsTo(P5Project::class,'p5_project_id'); }

    /**
     * Get dimension name based on dimension_id
     * 1=Beriman, 2=Bernalar Kritis, 3=Mandiri, 4=Berkebinekaan, 5=Kreatif, 6=Bergotong Royong
     */
    public function getDimensionNameAttribute()
    {
        $dimensions = [
            1 => 'Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia',
            2 => 'Bernalar Kritis',
            3 => 'Mandiri',
            4 => 'Berkebinekaan Global',
            5 => 'Kreatif',
            6 => 'Bergotong Royong',
        ];

        return $dimensions[$this->dimension_id] ?? null;
    }
}
