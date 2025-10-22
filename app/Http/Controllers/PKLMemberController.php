<?php
namespace App\Http\Controllers;

use App\Models\{PKLGroup,PKLGroupMember,Student,SchoolClass};
use Illuminate\Http\Request;

class PKLMemberController extends Controller
{
    public function index(PKLGroup $group, Request $r)
    {
        $classId = $r->get('class_id', $group->class_id);

        $classes = SchoolClass::where('school_id',$group->school_id)
            ->orderBy('tingkat_pendidikan')->orderBy('nama_kelas')->pluck('nama_kelas','id');

        $memberIds = PKLGroupMember::where('pkl_group_id',$group->id)->pluck('student_id');
        $enrolled = Student::whereIn('id',$memberIds)->orderBy('nama')->get();

        $candidates = Student::where('school_id',$group->school_id)
            ->when($classId, fn($q)=>$q->where('class_id',$classId))
            ->orderBy('nama')->get();

        return view('pkl.members.index', compact('group','classes','classId','enrolled','candidates'));
    }

    public function enrollClass(PKLGroup $group, Request $r)
    {
        $r->validate(['class_id'=>['required','exists:classes,id']]);
        $sids = \App\Models\Student::where('class_id',$r->class_id)->pluck('id');
        foreach ($sids as $sid) {
            PKLGroupMember::firstOrCreate(['pkl_group_id'=>$group->id,'student_id'=>$sid]);
        }
        return back()->with('ok','Semua siswa kelas ditambahkan.');
    }

    public function store(PKLGroup $group, Request $r)
    {
        $data = $r->validate(['student_id'=>['required','exists:students,id']]);
        PKLGroupMember::firstOrCreate(['pkl_group_id'=>$group->id,'student_id'=>$data['student_id']]);
        return back()->with('ok','Siswa ditambahkan.');
    }

    public function destroy(PKLGroup $group, $studentId)
    {
        PKLGroupMember::where(['pkl_group_id'=>$group->id,'student_id'=>$studentId])->delete();
        return back()->with('ok','Siswa dihapus dari kelompok.');
    }
}
