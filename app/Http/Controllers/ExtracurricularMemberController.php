<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Extracurricular, ExtracurricularMember, Semester, SchoolClass, Student};

class ExtracurricularMemberController extends Controller
{
    public function index(Request $r, Extracurricular $ex)
    {
        // dropdowns
        $semesters = Semester::orderByDesc('id')->get(['id','tahun_ajaran','semester']);
        $semesterId = (int) $r->query(
            'semester_id',
            optional($semesters->firstWhere('status','berjalan'))->id ?? optional($semesters->first())->id
        );

        $classes    = SchoolClass::where('school_id', $ex->school_id)->orderBy('nama_kelas')->get(['id','nama_kelas']);
        $classId    = (int) $r->query('class_id');

        // --- Sudah terdaftar (urut nama siswa) ---
        $members = ExtracurricularMember::with('student:id,nama,class_id')
            ->where('extracurricular_id', $ex->id)
            ->where('semester_id', $semesterId)
            ->leftJoin('students', 'students.id', '=', 'extracurricular_members.student_id')
            ->when($classId, fn($q) => $q->where('students.class_id', $classId))
            ->orderBy('students.nama')                   // <= pengganti orderByRelation
            ->select('extracurricular_members.*')        // penting: kolom model utama
            ->get();

        // --- Kandidat (siswa yang belum terdaftar) ---
        $alreadyIds = $members->pluck('student_id');
        $candidates = Student::when($classId, fn($q)=>$q->where('class_id',$classId))
            ->whereNotIn('id', $alreadyIds)
            ->orderBy('nama')
            ->get(['id','nama']);

        return view('extracurriculars.members', [
            'ex'         => $ex,
            'semesters'  => $semesters,
            'semesterId' => $semesterId,
            'classes'    => $classes,
            'classId'    => $classId,
            'members'    => $members,
            'candidates' => $candidates,
        ]);
    }

    public function store(Request $r, Extracurricular $ex)
    {
        $data = $r->validate([
            'semester_id' => ['required','exists:semesters,id'],
            'student_id'  => ['required','exists:students,id'],
        ]);

        // aman terhadap duplikasi (ada unique uk_exm)
        ExtracurricularMember::firstOrCreate([
            'extracurricular_id' => $ex->id,
            'semester_id'        => $data['semester_id'],
            'student_id'         => $data['student_id'],
        ]);

        return back()->with('ok','Siswa ditambahkan.');
    }

    public function storeAll(Request $r, Extracurricular $ex)
    {
        $data = $r->validate([
            'semester_id' => ['required','exists:semesters,id'],
            'class_id'    => ['required','exists:classes,id'],
        ]);

        $studentIds = Student::where('class_id', $data['class_id'])->pluck('id');

        foreach ($studentIds as $sid) {
            ExtracurricularMember::firstOrCreate([
                'extracurricular_id' => $ex->id,
                'semester_id'        => $data['semester_id'],
                'student_id'         => $sid,
            ]);
        }

        return back()->with('ok','Semua siswa kelas ditambahkan.');
    }

    public function destroy(Extracurricular $ex, ExtracurricularMember $member)
    {
        // opsional: pastikan belong to same extracurricular
        abort_if($member->extracurricular_id !== $ex->id, 404);
        $member->delete();

        return back()->with('ok','Anggota dihapus.');
    }
}
