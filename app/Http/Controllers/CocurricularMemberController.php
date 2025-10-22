<?php
namespace App\Http\Controllers;

use App\Models\{CocurricularActivity,CocurricularMember,Student,SchoolClass};
use Illuminate\Http\Request;

class CocurricularMemberController extends Controller
{
    public function index(CocurricularActivity $co, Request $r)
    {
        $classId = $r->get('class_id', $co->class_id);

        $classes = SchoolClass::where('school_id',$co->school_id)
            ->orderBy('tingkat_pendidikan')->orderBy('nama_kelas')->pluck('nama_kelas','id');

        $memberIds = CocurricularMember::where('cocurricular_id',$co->id)->pluck('student_id');
        $enrolled  = Student::whereIn('id',$memberIds)->orderBy('nama')->get();

        $candidates = Student::where('school_id',$co->school_id)
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderBy('nama')->get();

        return view('cocurriculars.members', compact('co','classes','classId','enrolled','candidates'));
    }

    public function enrollClass(CocurricularActivity $co, Request $r)
    {
        $r->validate(['class_id'=>['required','exists:classes,id']]);
        $sids = \App\Models\Student::where('class_id',$r->class_id)->pluck('id');
        foreach ($sids as $sid) {
            CocurricularMember::firstOrCreate(['cocurricular_id'=>$co->id,'student_id'=>$sid]);
        }
        return back()->with('ok','Semua siswa kelas ditambahkan.');
    }

    public function store(CocurricularActivity $co, Request $r)
    {
        $data = $r->validate(['student_id'=>['required','exists:students,id']]);
        CocurricularMember::firstOrCreate(['cocurricular_id'=>$co->id,'student_id'=>$data['student_id']]);
        return back()->with('ok','Siswa ditambahkan.');
    }

    public function destroy(CocurricularActivity $co, $studentId)
    {
        CocurricularMember::where(['cocurricular_id'=>$co->id,'student_id'=>$studentId])->delete();
        return back()->with('ok','Siswa dihapus dari kegiatan.');
    }
}
