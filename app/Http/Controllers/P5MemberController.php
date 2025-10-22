<?php
namespace App\Http\Controllers;

use App\Models\{P5Project,P5ProjectStudent,Student};
use Illuminate\Http\Request;

class P5MemberController extends Controller
{
    public function index(P5Project $p5)
    {
        $enrolledIds = $p5->members()->pluck('student_id')->all();
        $enrolled = Student::whereIn('id',$enrolledIds)->orderBy('nama')->get();
        $notYet   = Student::where('class_id',$p5->class_id)->whereNotIn('id',$enrolledIds)
                    ->orderBy('nama')->get();

        return view('p5.members.index', compact('p5','enrolled','notYet'));
    }

    public function enrollAll(P5Project $p5)
    {
        $students = Student::where('class_id',$p5->class_id)->pluck('id');
        foreach ($students as $sid) {
            P5ProjectStudent::firstOrCreate(['p5_project_id'=>$p5->id,'student_id'=>$sid]);
        }
        return back()->with('ok','Semua siswa kelas ditambahkan ke projek.');
    }

    public function store(Request $r, P5Project $p5)
    {
        $r->validate(['student_id'=>['required','exists:students,id']]);
        P5ProjectStudent::firstOrCreate(['p5_project_id'=>$p5->id,'student_id'=>$r->student_id]);
        return back()->with('ok','Siswa ditambahkan.');
    }

    public function destroy(P5Project $p5, $studentId)
    {
        P5ProjectStudent::where(['p5_project_id'=>$p5->id,'student_id'=>$studentId])->delete();
        return back()->with('ok','Siswa dihapus dari projek.');
    }
}
