<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\SchoolClass;
use App\Models\Student;

class ReportClassBoardController extends Controller
{
    public function index(Request $r)
    {
        // Ambil semester aktif (atau terakhir jika belum diset)
        $semester = Semester::where('status','berjalan')->latest('id')->first()
                  ?? Semester::latest('id')->first();

        if (!$semester) {
            abort(404, 'Belum ada data semester.');
        }

        // Dropdown kelas di sekolah semester ini
        $classes  = SchoolClass::where('school_id', $semester->school_id)
                    ->orderBy('nama_kelas')->get(['id','nama_kelas']);

        // Kelas terpilih
        $classId  = (int) $r->query('class_id', ($classes->first()->id ?? 0));

        // Siswa kelas terpilih
        $students = $classId
            ? Student::where('class_id',$classId)->orderBy('nama')->get()
            : collect();

        return view('reports.class_board', [
            'semester' => $semester,
            'classes'  => $classes,
            'classId'  => $classId,
            'students' => $students,
        ]);
    }
}
