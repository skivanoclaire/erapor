<?php
namespace App\Http\Controllers;

use App\Models\{ReportSetting,School,Semester,MediaUpload};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportSettingController extends Controller
{
    public function index(Request $r)
    {
        $schoolId = $r->get('school_id');
        $semesterId = $r->get('semester_id');

        $rows = ReportSetting::with(['school','semester','ttd','logoPemda','logoSekolah'])
            ->when($schoolId, fn($q)=>$q->where('school_id',$schoolId))
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->orderByDesc('id')->paginate(15)->withQueryString();

        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']);

        return view('report_settings.index', compact('rows','schools','semesters','schoolId','semesterId'));
    }

    public function create()
    {
        return view('report_settings.create', [
            'schools'=>School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters'=>Semester::orderByDesc('id')->get()
                ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
            'media'=>MediaUpload::with('school')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $r)
    {
        $schoolId = (int)$r->input('school_id');

        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'tempat_cetak'=> ['nullable','string','max:150'],
            'nama_kementerian'=>['nullable','string','max:200'],
            'jenis_kertas'=> ['required', Rule::in(['A4','F4','Letter'])],
            'margin_top_cm'=>['required','numeric','min:0','max:10'],
            'format_penulisan_nama'=>['required', Rule::in(['Data Asli','Huruf Kapital','Title Case'])],
            'tampilkan_nilai_desimal'=>['nullable','boolean'],
            'tampilkan_keputusan'=>['nullable','boolean'],
            'label_id_wali'=>['required','string','max:20'],
            'label_id_kepsek'=>['required','string','max:20'],
            'label_id_siswa_footer'=>['required','string','max:20'],
            'judul_rapor'=>['required','string','max:150'],
            'ttd_kepsek_media_id' => ['nullable', Rule::exists('media_uploads','id')->where('school_id',$schoolId)],
            'logo_pemda_media_id' => ['nullable', Rule::exists('media_uploads','id')->where('school_id',$schoolId)],
            'logo_sekolah_media_id' => ['nullable', Rule::exists('media_uploads','id')->where('school_id',$schoolId)],
            'p5_on_new_page'=>['nullable','boolean'],
            'ekskul_on_new_page'=>['nullable','boolean'],
            'catatan_on_new_page'=>['nullable','boolean'],
        ]);

        $data['tampilkan_nilai_desimal'] = $r->boolean('tampilkan_nilai_desimal');
        $data['tampilkan_keputusan']     = $r->boolean('tampilkan_keputusan');
        $data['p5_on_new_page']          = $r->boolean('p5_on_new_page');
        $data['ekskul_on_new_page']      = $r->boolean('ekskul_on_new_page');
        $data['catatan_on_new_page']     = $r->boolean('catatan_on_new_page');

        // enforce unik (school_id + semester_id)
        $exists = ReportSetting::where('school_id',$data['school_id'])
                   ->where('semester_id',$data['semester_id'])->first();
        if ($exists) {
            return back()->withErrors(['semester_id'=>'Sudah ada pengaturan untuk sekolah & semester ini.'])->withInput();
        }

        ReportSetting::create($data);
        return redirect()->route('report-settings.index')->with('ok','Pengaturan rapor dibuat.');
    }

    public function edit(ReportSetting $report_setting)
    {
        return view('report_settings.edit', [
            'row'=>$report_setting,
            'schools'=>School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'semesters'=>Semester::orderByDesc('id')->get()
                ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
            // tampilkan media milik sekolah terkait dulu (paling relevan)
            'media'=>MediaUpload::where('school_id',$report_setting->school_id)->orderByDesc('id')->get(),
        ]);
    }

    public function update(Request $r, ReportSetting $report_setting)
    {
        $schoolId = (int)$r->input('school_id');

        $data = $r->validate([
            'school_id'   => ['required','exists:schools,id'],
            'semester_id' => ['required','exists:semesters,id'],
            'tempat_cetak'=> ['nullable','string','max:150'],
            'nama_kementerian'=>['nullable','string','max:200'],
            'jenis_kertas'=> ['required', Rule::in(['A4','F4','Letter'])],
            'margin_top_cm'=>['required','numeric','min:0','max:10'],
            'format_penulisan_nama'=>['required', Rule::in(['Data Asli','Huruf Kapital','Title Case'])],
            'tampilkan_nilai_desimal'=>['nullable','boolean'],
            'tampilkan_keputusan'=>['nullable','boolean'],
            'label_id_wali'=>['required','string','max:20'],
            'label_id_kepsek'=>['required','string','max:20'],
            'label_id_siswa_footer'=>['required','string','max:20'],
            'judul_rapor'=>['required','string','max:150'],
            'ttd_kepsek_media_id' => ['nullable', Rule::exists('media_uploads','id')->where('school_id',$schoolId)],
            'logo_pemda_media_id' => ['nullable', Rule::exists('media_uploads','id')->where('school_id',$schoolId)],
            'logo_sekolah_media_id' => ['nullable', Rule::exists('media_uploads','id')->where('school_id',$schoolId)],
            'p5_on_new_page'=>['nullable','boolean'],
            'ekskul_on_new_page'=>['nullable','boolean'],
            'catatan_on_new_page'=>['nullable','boolean'],
        ]);

        // pastikan kombinasi unik (kecuali dirinya sendiri)
        $dup = ReportSetting::where('school_id',$data['school_id'])
            ->where('semester_id',$data['semester_id'])
            ->where('id','<>',$report_setting->id)->exists();
        if ($dup) {
            return back()->withErrors(['semester_id'=>'Sudah ada pengaturan untuk sekolah & semester ini.'])->withInput();
        }

        $data['tampilkan_nilai_desimal'] = $r->boolean('tampilkan_nilai_desimal');
        $data['tampilkan_keputusan']     = $r->boolean('tampilkan_keputusan');
        $data['p5_on_new_page']          = $r->boolean('p5_on_new_page');
        $data['ekskul_on_new_page']      = $r->boolean('ekskul_on_new_page');
        $data['catatan_on_new_page']     = $r->boolean('catatan_on_new_page');

        $report_setting->update($data);
        return back()->with('ok','Pengaturan rapor diperbarui.');
    }
}
