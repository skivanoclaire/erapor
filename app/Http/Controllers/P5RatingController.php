<?php
namespace App\Http\Controllers;

use App\Models\{P5Project,P5ProjectRating,P5ProjectCriterion,Student,P5ProjectStudent};
use Illuminate\Http\Request;

class P5RatingController extends Controller
{
    // daftar siswa anggota projek
    public function index(P5Project $p5)
    {
        $students = Student::join('p5_project_students as m','m.student_id','=','students.id')
            ->where('m.p5_project_id',$p5->id)
            ->orderBy('students.nama')->get(['students.id','students.nama']);

        return view('p5.ratings.index', compact('p5','students'));
    }

    // form nilai untuk 1 siswa
    public function edit(P5Project $p5, $studentId)
    {
        // pastikan anggota
        if (!P5ProjectStudent::where('p5_project_id',$p5->id)->where('student_id',$studentId)->exists())
            abort(404);

        $student   = Student::findOrFail($studentId);
        $criteria  = $p5->criteria()->get();
        $map = P5ProjectRating::where('p5_project_id',$p5->id)
                ->where('student_id',$studentId)
                ->get()->keyBy('criterion_id');

        $levels = ['MB'=>'MB','BSH'=>'BSH','SB'=>'SB','SAB'=>'SAB','-'=>'-'];

        return view('p5.ratings.edit', compact('p5','student','criteria','map','levels'));
    }

    public function update(Request $r, P5Project $p5, $studentId)
    {
        $payload = $r->get('level', []);      // [criterion_id => level]
        $desc    = $r->get('desc', []);       // [criterion_id => text]

        foreach ($payload as $cid => $level) {
            P5ProjectRating::updateOrCreate(
                ['p5_project_id'=>$p5->id,'criterion_id'=>$cid,'student_id'=>$studentId],
                ['level'=>$level, 'description'=>$desc[$cid] ?? null]
            );
        }
        return back()->with('ok','Penilaian disimpan.');
    }
}
