<?php
namespace App\Http\Controllers;

use App\Models\{ReportDate,Semester,SchoolClass};
use Illuminate\Http\Request;

class ReportDateController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $rows = ReportDate::with(['semester','class'])
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderByDesc('id')->paginate(15)->withQueryString();

        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']);
        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('report_dates.index', compact('rows','semesters','classes','semesterId','classId'));
    }

    public function create()
    {
        return view('report_dates.create', [
            'semesters'=>Semester::orderByDesc('id')->get()
                ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'semester_id'     => ['required','exists:semesters,id'],
            'class_id'        => ['required','exists:classes,id'],
            'mid_report_date' => ['nullable','date'],
            'final_report_date'=>['nullable','date'],
        ]);

        $dup = ReportDate::where('semester_id',$data['semester_id'])
            ->where('class_id',$data['class_id'])->exists();
        if ($dup) return back()->withErrors(['class_id'=>'Tanggal rapor untuk kelas & semester ini sudah ada.'])->withInput();

        ReportDate::create($data);
        return redirect()->route('rdate.index')->with('ok','Tanggal rapor disimpan.');
    }

    public function edit(ReportDate $rdate)
    {
        return view('report_dates.edit', [
            'row'=>$rdate,
            'semesters'=>\App\Models\Semester::orderByDesc('id')->get()
                ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>\App\Models\SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
        ]);
    }

    public function update(Request $r, ReportDate $rdate)
    {
        $data = $r->validate([
            'semester_id'     => ['required','exists:semesters,id'],
            'class_id'        => ['required','exists:classes,id'],
            'mid_report_date' => ['nullable','date'],
            'final_report_date'=>['nullable','date'],
        ]);

        $dup = ReportDate::where('semester_id',$data['semester_id'])
            ->where('class_id',$data['class_id'])
            ->where('id','<>',$rdate->id)->exists();
        if ($dup) return back()->withErrors(['class_id'=>'Tanggal rapor untuk kelas & semester ini sudah ada.'])->withInput();

        $rdate->update($data);
        return back()->with('ok','Tanggal rapor diperbarui.');
    }

    public function destroy(ReportDate $rdate)
    {
        $rdate->delete();
        return back()->with('ok','Tanggal rapor dihapus.');
    }
}
