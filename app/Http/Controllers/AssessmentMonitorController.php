<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ClassSubject,Semester,SchoolClass};

class AssessmentMonitorController extends Controller
{
    public function index(Request $r)
    {
        $semesterId = $r->get('semester_id');
        $classId    = $r->get('class_id');

        $rows = ClassSubject::with(['subject','teacher','class','semester'])
            ->when($semesterId, fn($q)=>$q->where('semester_id',$semesterId))
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->where('active',1)
            ->withCount([
                'assessments as formatif_count'   => fn($q)=>$q->where('type','formatif'),
                'assessments as sumatif_count'    => fn($q)=>$q->where('type','sumatif'),
                'assessments as sumatif_as_count' => fn($q)=>$q->where('type','sumatif_as'),
            ])
            ->orderBy('class_id')->orderBy('order_no')
            ->get();

        $semesters = Semester::orderByDesc('id')->get()
            ->mapWithKeys(fn($s)=>[$s->id=>$s->tahun_ajaran.' ('.$s->semester.')']);
        $classes   = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('monitor_penilaian.index', compact('rows','semesters','classes','semesterId','classId'));
    }
}
