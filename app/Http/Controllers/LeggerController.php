<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Semester,SchoolClass,ClassSubject,Student,FinalGrade};

class LeggerController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']);
        $classes   = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        $subjects = collect();
        $students = collect();
        $matrix   = []; // [student_id][class_subject_id] => score

        if ($semesterId && $classId) {
            // Ambil mapel aktif; untuk MVP kita tampilkan induk saja (combined_with_id null)
            $subjects = ClassSubject::with('subject')
                ->where('semester_id',$semesterId)
                ->where('class_id',$classId)
                ->where('active',1)
                ->whereNull('combined_with_id')
                ->orderBy('order_no')
                ->get();

            $students = Student::where('class_id',$classId)
                ->orderBy('nama')->get();

            if ($subjects->isNotEmpty() && $students->isNotEmpty()) {
                $csIds = $subjects->pluck('id');
                $stIds = $students->pluck('id');

                $scores = FinalGrade::whereIn('class_subject_id',$csIds)
                    ->whereIn('student_id',$stIds)->get();

                foreach ($scores as $sc) {
                    $matrix[$sc->student_id][$sc->class_subject_id] = $sc->final_score;
                }
            }
        }

        return view('legger.index', compact(
            'semesters','classes','semesterId','classId','subjects','students','matrix'
        ));
    }
}
