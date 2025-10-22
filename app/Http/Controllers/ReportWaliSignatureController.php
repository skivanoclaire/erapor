<?php
namespace App\Http\Controllers;

use App\Models\{ReportWaliSignature,Semester,SchoolClass,User,MediaUpload};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportWaliSignatureController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $rows = ReportWaliSignature::with(['semester','class','wali','media'])
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderByDesc('id')->paginate(15)->withQueryString();

        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']);
        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('report_wali_signatures.index', compact('rows','semesters','classes','semesterId','classId'));
    }

    public function create()
    {
        return view('report_wali_signatures.create', [
            'semesters'=>Semester::orderByDesc('id')->get()
                ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'wali'=>User::orderBy('nama')->pluck('nama','id'),
            'media'=>MediaUpload::orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'semester_id'        => ['required','exists:semesters,id'],
            'class_id'           => ['required','exists:classes,id'],
            'wali_id'            => ['nullable','exists:users,id'],
            'signature_media_id' => ['nullable','exists:media_uploads,id'],
        ]);

        // unik per (semester_id, class_id)
        $dup = ReportWaliSignature::where('semester_id',$data['semester_id'])
            ->where('class_id',$data['class_id'])->exists();
        if ($dup) return back()->withErrors(['class_id'=>'TTD untuk kelas & semester ini sudah ada.'])->withInput();

        ReportWaliSignature::create($data);
        return redirect()->route('rws.index')->with('ok','TTD wali disimpan.');
    }

    public function edit(ReportWaliSignature $rws)
    {
        return view('report_wali_signatures.edit', [
            'row'=>$rws,
            'semesters'=>Semester::orderByDesc('id')->get()
                ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
            'classes'=>SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
            'wali'=>User::orderBy('nama')->pluck('nama','id'),
            'media'=>MediaUpload::orderByDesc('id')->get(),
        ]);
    }

    public function update(Request $r, ReportWaliSignature $rws)
    {
        $data = $r->validate([
            'semester_id'        => ['required','exists:semesters,id'],
            'class_id'           => ['required','exists:classes,id'],
            'wali_id'            => ['nullable','exists:users,id'],
            'signature_media_id' => ['nullable','exists:media_uploads,id'],
        ]);

        $dup = ReportWaliSignature::where('semester_id',$data['semester_id'])
            ->where('class_id',$data['class_id'])
            ->where('id','<>',$rws->id)->exists();
        if ($dup) return back()->withErrors(['class_id'=>'TTD untuk kelas & semester ini sudah ada.'])->withInput();

        $rws->update($data);
        return back()->with('ok','TTD wali diperbarui.');
    }

    public function destroy(ReportWaliSignature $rws)
    {
        $rws->delete();
        return back()->with('ok','TTD wali dihapus.');
    }
}
