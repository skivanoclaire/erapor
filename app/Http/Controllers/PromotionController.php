<?php
namespace App\Http\Controllers;

use App\Models\{SchoolClass,Semester,Student,Promotion};
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(SchoolClass $class, Semester $semester)
    {
        $students = Student::where('class_id',$class->id)->orderBy('nama')->get(['id','nama']);
        $map = Promotion::where('semester_id',$semester->id)
                ->where('class_id',$class->id)
                ->get()->keyBy('student_id');

        // opsi kelas tujuan: semua kelas di sekolah yang sama (bebas pilih)
        $nextClasses = SchoolClass::where('school_id',$class->school_id)
                        ->orderBy('tingkat_pendidikan')->orderBy('nama_kelas')
                        ->get(['id','nama_kelas'])->pluck('nama_kelas','id');

        return view('promotions.index', compact('class','semester','students','map','nextClasses'));
    }

    public function store(Request $r, SchoolClass $class, Semester $semester)
    {
        $promoted = $r->get('promoted', []);      // [sid => '1'|'0']
        $next     = $r->get('next', []);          // [sid => next_class_id]
        $note     = $r->get('note', []);          // [sid => text]

        foreach ($r->get('ids', []) as $sid) {
            Promotion::updateOrCreate(
                ['semester_id'=>$semester->id,'class_id'=>$class->id,'student_id'=>$sid],
                [
                    'school_id'     => $class->school_id,
                    'promoted'      => isset($promoted[$sid]) ? (bool)$promoted[$sid] : true,
                    'next_class_id' => $next[$sid] ?? null,
                    'note'          => $note[$sid] ?? null,
                    'decided_at'    => now(),
                ]
            );
        }
        return back()->with('ok','Keputusan kenaikan disimpan.');
    }
}
