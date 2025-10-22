<?php
namespace App\Http\Controllers;

use App\Models\{ReportCustomization,School};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportCustomizationController extends Controller
{
    private array $fonts = ['Arial','Times New Roman','Calibri','Cambria','Verdana','Tahoma','Georgia'];

    public function index(Request $r)
    {
        $schoolId = $r->get('school_id');

        $rows = ReportCustomization::with('school')
            ->when($schoolId, fn($q)=>$q->where('school_id',$schoolId))
            ->orderBy('apply_to')->orderBy('school_id')
            ->paginate(15)->withQueryString();

        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');

        return view('report_customizations.index', compact('rows','schools','schoolId'));
    }

    public function create()
    {
        return view('report_customizations.create', [
            'schools'=>School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'fonts'=>$this->fonts,
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'apply_to'  => ['required', Rule::in(['Rapor Tengah Semester','Rapor Akhir Semester'])],
            'font_family'=>['required','string','max:50'],
            'title_font_size' => ['required','numeric','min:8','max:48'],
            'table_header_font_size' => ['required','numeric','min:8','max:32'],
            'table_body_font_size' => ['required','numeric','min:8','max:32'],
        ]);

        // Boleh unik per (school_id, apply_to) agar tidak dobel
        $dup = ReportCustomization::where('school_id',$data['school_id'])
            ->where('apply_to',$data['apply_to'])->exists();
        if ($dup) return back()->withErrors(['apply_to'=>'Kustom untuk sekolah & jenis rapor ini sudah ada.'])->withInput();

        ReportCustomization::create($data);
        return redirect()->route('rc.index')->with('ok','Kustom font disimpan.');
    }

    public function edit(ReportCustomization $rc)
    {
        return view('report_customizations.edit', [
            'row'=>$rc,
            'schools'=>\App\Models\School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
            'fonts'=>$this->fonts,
        ]);
    }

    public function update(Request $r, ReportCustomization $rc)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'apply_to'  => ['required', Rule::in(['Rapor Tengah Semester','Rapor Akhir Semester'])],
            'font_family'=>['required','string','max:50'],
            'title_font_size' => ['required','numeric','min:8','max:48'],
            'table_header_font_size' => ['required','numeric','min:8','max:32'],
            'table_body_font_size' => ['required','numeric','min:8','max:32'],
        ]);

        $dup = ReportCustomization::where('school_id',$data['school_id'])
            ->where('apply_to',$data['apply_to'])
            ->where('id','<>',$rc->id)->exists();
        if ($dup) return back()->withErrors(['apply_to'=>'Kustom untuk sekolah & jenis rapor ini sudah ada.'])->withInput();

        $rc->update($data);
        return back()->with('ok','Kustom font diperbarui.');
    }

    public function destroy(ReportCustomization $rc)
    {
        $rc->delete();
        return back()->with('ok','Kustom font dihapus.');
    }
}
