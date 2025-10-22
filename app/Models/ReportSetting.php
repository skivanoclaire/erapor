<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    protected $fillable = [
        'school_id','semester_id','tempat_cetak','nama_kementerian','jenis_kertas','margin_top_cm',
        'format_penulisan_nama','tampilkan_nilai_desimal','tampilkan_keputusan',
        'label_id_wali','label_id_kepsek','label_id_siswa_footer','judul_rapor',
        'ttd_kepsek_media_id','logo_pemda_media_id','logo_sekolah_media_id',
        'p5_on_new_page','ekskul_on_new_page','catatan_on_new_page'
    ];
    protected $casts = [
        'tampilkan_nilai_desimal'=>'boolean',
        'tampilkan_keputusan'=>'boolean',
        'p5_on_new_page'=>'boolean',
        'ekskul_on_new_page'=>'boolean',
        'catatan_on_new_page'=>'boolean',
        'margin_top_cm'=>'decimal:1',
    ];

    public function school(){ return $this->belongsTo(School::class); }
    public function semester(){ return $this->belongsTo(Semester::class); }
    public function ttd(){ return $this->belongsTo(MediaUpload::class,'ttd_kepsek_media_id'); }
    public function logoPemda(){ return $this->belongsTo(MediaUpload::class,'logo_pemda_media_id'); }
    public function logoSekolah(){ return $this->belongsTo(MediaUpload::class,'logo_sekolah_media_id'); }
}
