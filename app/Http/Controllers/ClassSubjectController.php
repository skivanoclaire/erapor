<?php

namespace App\Http\Controllers;

use App\Models\{ClassSubject,School,Semester,SchoolClass,Subject,User};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ClassSubjectController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId = $r->get('class_id');

        $rows = ClassSubject::with(['subject','class','teacher','semester'])
            ->when($semesterId, fn($x)=>$x->where('semester_id',$semesterId))
            ->when($classId, fn($x)=>$x->where('class_id',$classId))
            ->orderBy('class_id')->orderBy('order_no')
            ->paginate(20)->withQueryString();

        $semesters = Semester::orderByDesc('id')->pluck('tahun_ajaran','id')
                     ->map(fn($ta,$id)=>$ta.' ('.Semester::find($id)->semester.')');
        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('class_subjects.index', compact('rows','semesters','classes','semesterId','classId'));
    }

public function create(Request $r)
{
    $semesterId = $r->get('semester_id');
    $classId    = $r->get('class_id');

    $candidates = collect();
    if ($semesterId && $classId) {
        $candidates = ClassSubject::with('subject')
            ->where('semester_id', $semesterId)
            ->where('class_id', $classId)
            ->orderBy('order_no')
            ->get()
            ->mapWithKeys(fn($row) => [
                $row->id => sprintf('%s — urut %d (#%d)',
                    $row->subject?->short_name ?? 'MAPEL', $row->order_no, $row->id)
            ]);
    }

    return view('class_subjects.create', [
        'schools'    => School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
        'semesters'  => Semester::orderByDesc('id')->get()
                          ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
        'classes'    => SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
        'subjects'   => Subject::orderBy('short_name')->pluck('short_name','id'),
        'teachers'   => User::orderBy('nama')->pluck('nama','id'),
        'candidates' => $candidates, // sudah rapi
        // biar option default kepilih:
        'semesterId' => $semesterId,
        'classId'    => $classId,
    ]);
}


public function store(Request $r)
{
    $data = $r->validate([
        'school_id'        => ['required','exists:schools,id'],
        'semester_id'      => ['required','exists:semesters,id'],
        'class_id'         => ['required','exists:classes,id'],
        'subject_id'       => [
            'required','exists:subjects,id',
            // unik per (semester_id, class_id, subject_id)
            Rule::unique('class_subjects')->where(fn($q)=>$q
                ->where('semester_id',$r->semester_id)
                ->where('class_id',$r->class_id)),
        ],
        'order_no'         => ['nullable','integer','min:1'],
        'teacher_id'       => ['nullable','exists:users,id'],
        'combined_with_id' => ['nullable','integer','exists:class_subjects,id'],
        'group'            => ['nullable','string','max:50'],
        'active'           => ['nullable','boolean'],
    ]);

    // normalisasi
    $data['order_no'] = $data['order_no'] ?? 1;
    $data['active']   = $r->boolean('active');

    // === Cross-field validation untuk "Gabung dengan" ===
    if (!empty($data['combined_with_id'])) {
        $parent = ClassSubject::select('id','semester_id','class_id','combined_with_id')
                    ->find($data['combined_with_id']);

        // 1) harus kelas & semester yang sama
        if (!$parent || $parent->semester_id != $data['semester_id'] || $parent->class_id != $data['class_id']) {
            return back()->withErrors([
                'combined_with_id' => 'Harus memilih mapel pada kelas & semester yang sama.'
            ])->withInput();
        }

        // 2) anti-siklus (store belum punya id; cukup pastikan chain parent tidak melingkar)
        $seen = [$parent->id];
        $cur  = $parent;
        $steps = 0;
        while ($cur && $cur->combined_with_id && $steps < 20) {
            if (in_array($cur->combined_with_id, $seen, true)) {
                return back()->withErrors([
                    'combined_with_id' => 'Pilihan ini menyebabkan siklus gabungan. Pilih induk lain.'
                ])->withInput();
            }
            $seen[] = $cur->combined_with_id;
            $cur = ClassSubject::select('id','combined_with_id')->find($cur->combined_with_id);
            $steps++;
        }
    }

    ClassSubject::create($data);

    return redirect()->route('class-subjects.index', [
        'semester_id'=>$data['semester_id'],
        'class_id'=>$data['class_id'],
    ])->with('ok','Mapel kelas ditambahkan.');
}

public function edit(ClassSubject $cs)
{
    $candidates = ClassSubject::with('subject')
        ->where('semester_id',$cs->semester_id)
        ->where('class_id',$cs->class_id)
        ->where('id','!=',$cs->id) // jangan diri sendiri
        ->orderBy('order_no')
        ->get()
        ->mapWithKeys(fn($row)=>[
            $row->id => sprintf('%s — urut %d (#%d)',
                $row->subject?->short_name ?? 'MAPEL', $row->order_no, $row->id)
        ]);

    return view('class_subjects.edit', [
        'cs'         => $cs->load(['subject','class','teacher']),
        'schools'    => School::orderBy('nama_sekolah')->pluck('nama_sekolah','id'),
        'semesters'  => Semester::orderByDesc('id')->get()
                          ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']),
        'classes'    => SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id'),
        'subjects'   => Subject::orderBy('short_name')->pluck('short_name','id'),
        'teachers'   => User::orderBy('nama')->pluck('nama','id'),
        'candidates' => $candidates,
    ]);
}


public function update(Request $r, ClassSubject $cs)
{
    $data = $r->validate([
        'school_id'        => ['required','exists:schools,id'],
        'semester_id'      => ['required','exists:semesters,id'],
        'class_id'         => ['required','exists:classes,id'],
        'subject_id'       => [
            'required','exists:subjects,id',
            // unik per (semester_id, class_id, subject_id) kecuali dirinya
            Rule::unique('class_subjects')->ignore($cs->id)->where(fn($q)=>$q
                ->where('semester_id',$r->semester_id)
                ->where('class_id',$r->class_id)),
        ],
        'order_no'         => ['nullable','integer','min:1'],
        'teacher_id'       => ['nullable','exists:users,id'],
        'combined_with_id' => ['nullable','integer','exists:class_subjects,id'],
        'group'            => ['nullable','string','max:50'],
        'active'           => ['nullable','boolean'],
    ]);

    $data['order_no'] = $data['order_no'] ?? ($cs->order_no ?? 1);
    $data['active']   = $r->boolean('active');

    // === Cross-field validation untuk "Gabung dengan" ===
    if (!empty($data['combined_with_id'])) {
        // 0) tidak boleh menunjuk dirinya sendiri
        if ((int)$data['combined_with_id'] === (int)$cs->id) {
            return back()->withErrors([
                'combined_with_id' => 'Tidak boleh menunjuk dirinya sendiri sebagai induk.'
            ])->withInput();
        }

        $parent = ClassSubject::select('id','semester_id','class_id','combined_with_id')
                    ->find($data['combined_with_id']);

        // 1) harus kelas & semester yang sama
        if (!$parent || $parent->semester_id != $data['semester_id'] || $parent->class_id != $data['class_id']) {
            return back()->withErrors([
                'combined_with_id' => 'Harus memilih mapel pada kelas & semester yang sama.'
            ])->withInput();
        }

        // 2) anti-siklus (mis. A -> B lalu B -> A, atau chain yang berujung ke A)
        $seen  = [$cs->id];          // mulai dari dirinya, supaya jika chain mengarah balik ke dia -> siklus
        $cur   = $parent;
        $steps = 0;
        while ($cur && $steps < 20) {
            if (in_array($cur->id, $seen, true)) {
                return back()->withErrors([
                    'combined_with_id' => 'Pilihan ini menyebabkan siklus gabungan. Pilih induk lain.'
                ])->withInput();
            }
            $seen[] = $cur->id;

            if (!$cur->combined_with_id) break;
            $cur = ClassSubject::select('id','combined_with_id')->find($cur->combined_with_id);
            $steps++;
        }
    }

    $cs->update($data);

    return redirect()->route('class-subjects.index', [
        'semester_id'=>$data['semester_id'],
        'class_id'=>$data['class_id'],
    ])->with('ok','Mapel kelas diperbarui.');
}

    public function toggle(ClassSubject $cs)
    {
        $cs->update(['active'=>!$cs->active]);
        return back()->with('ok','Status mapel kelas diubah.');
    }

    public function destroy(ClassSubject $cs)
    {
        DB::transaction(function() use ($cs){
            $cs->enrollments()->delete();
            $cs->delete();
        });
        return back()->with('ok','Mapel kelas dihapus.');
    }
}
