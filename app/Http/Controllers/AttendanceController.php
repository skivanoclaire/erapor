<?php
namespace App\Http\Controllers;

use App\Models\{SchoolClass,Semester,Student,Attendance};
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function edit(SchoolClass $class, Semester $semester)
    {
        $students = Student::where('class_id',$class->id)->orderBy('nama')->get(['id','nama']);
        $map = Attendance::where('semester_id',$semester->id)
                ->whereIn('student_id',$students->pluck('id'))
                ->get()->keyBy('student_id');

        return view('attendance.edit', compact('class','semester','students','map'));
    }

    public function update(Request $r, SchoolClass $class, Semester $semester)
    {
        $data = $r->validate([
            'sakit' => ['array'],
            'izin'  => ['array'],
            'alpa'  => ['array'],
        ]);

        foreach ($r->get('ids', []) as $sid) {
            Attendance::updateOrCreate(
                ['student_id'=>$sid,'semester_id'=>$semester->id],
                [
                    'sakit' => max(0,(int)($data['sakit'][$sid] ?? 0)),
                    'izin'  => max(0,(int)($data['izin'][$sid]  ?? 0)),
                    'alpa'  => max(0,(int)($data['alpa'][$sid]  ?? 0)),
                ]
            );
        }

        return back()->with('ok','Absensi disimpan.');
    }
}
