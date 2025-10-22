<?php
namespace App\Http\Controllers;

use App\Models\{SchoolClass,Semester,Student,Note};
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function edit(SchoolClass $class, Semester $semester)
    {
        $students = Student::where('class_id',$class->id)->orderBy('nama')->get(['id','nama']);
        $map = Note::where('semester_id',$semester->id)
                ->whereIn('student_id',$students->pluck('id'))
                ->get()->keyBy('student_id');

        return view('notes.edit', compact('class','semester','students','map'));
    }

    public function update(Request $r, SchoolClass $class, Semester $semester)
    {
        foreach ($r->get('ids', []) as $sid) {
            Note::updateOrCreate(
                ['student_id'=>$sid,'semester_id'=>$semester->id],
                [
                    'catatan_tengah' => $r->input("ct.$sid"),
                    'catatan_akhir'  => $r->input("ca.$sid"),
                ]
            );
        }
        return back()->with('ok','Catatan disimpan.');
    }
}
