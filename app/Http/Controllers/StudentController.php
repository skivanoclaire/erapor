<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $r)
    {
        $q = trim((string)$r->get('q'));
        $classId = $r->get('class_id');

        $students = Student::with('class')
            ->when($classId, fn($x)=>$x->where('class_id',$classId))
            ->when($q, fn($x)=>$x->where(function($w) use ($q){
                $w->where('nama','like',"%$q%")->orWhere('nisn','like',"%$q%");
            }))
            ->orderBy('id','desc')->paginate(15)->withQueryString();

        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');

        return view('students.index', compact('students','q','classId','classes'));
    }

    public function create()
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');
        return view('students.create', compact('schools','classes'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'nisn' => ['required','string','max:20','unique:students,nisn'],
            'nama' => ['required','string','max:150'],
            'class_id' => ['nullable','exists:classes,id'],
            'jk' => ['required', Rule::in(['L','P'])],
            'tanggal_lahir' => ['nullable','date'],
            'nomor_rumah' => ['nullable','string','max:50'],
            'nomor_hp' => ['nullable','string','max:50'],
            'nis' => ['nullable','string','max:30'],
            'nisn'=> ['nullable','string','max:30'],
            'nik' => ['nullable','string','max:30'],
            'tempat_lahir' => ['nullable','string','max:100'],
            'agama' => ['nullable','string','max:30'],
            'status_dalam_keluarga' => ['nullable','string','max:50'],
            'anak_ke' => ['nullable','integer','min:1','max:20'],

            'alamat'      => ['nullable','string'],

            'berat_badan'  => ['nullable','integer','min:0','max:300'],
            'tinggi_badan' => ['nullable','integer','min:0','max:300'],

            'sekolah_asal' => ['nullable','string','max:150'],
            'tanggal_masuk_sekolah' => ['nullable','date'],
            'diterima_di_kelas'     => ['nullable','string','max:50'],

            'nama_ayah' => ['nullable','string','max:150'],
            'pekerjaan_ayah' => ['nullable','string','max:100'],
            'nama_ibu' => ['nullable','string','max:150'],
            'pekerjaan_ibu' => ['nullable','string','max:100'],
            'telepon_rumah' => ['nullable','string','max:30'],
            'alamat_orang_tua' => ['nullable','string'],

            'nama_wali' => ['nullable','string','max:150'],
            'pekerjaan_wali' => ['nullable','string','max:100'],
            'telepon_wali' => ['nullable','string','max:30'],
            'alamat_wali' => ['nullable','string'],
        ]);
        Student::create($data);
        return redirect()->route('students.index')->with('ok','Siswa dibuat.');
    }

    public function edit(Student $student)
    {
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');
        $classes = SchoolClass::orderBy('nama_kelas')->pluck('nama_kelas','id');
        return view('students.edit', compact('student','schools','classes'));
    }

    public function update(Request $r, Student $student)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'nisn' => ['required','string','max:20', Rule::unique('students','nisn')->ignore($student->id)],
            'nama' => ['required','string','max:150'],
            'class_id' => ['nullable','exists:classes,id'],
            'jk' => ['required', Rule::in(['L','P'])],
            'tanggal_lahir' => ['nullable','date'],
            'nomor_rumah' => ['nullable','string','max:50'],
            'nomor_hp' => ['nullable','string','max:50'],
            'nis' => ['nullable','string','max:30'],
            'nisn'=> ['nullable','string','max:30'],
            'nik' => ['nullable','string','max:30'],
            'tempat_lahir' => ['nullable','string','max:100'],
            'agama' => ['nullable','string','max:30'],
            'status_dalam_keluarga' => ['nullable','string','max:50'],
            'anak_ke' => ['nullable','integer','min:1','max:20'],

            'alamat'      => ['nullable','string'],

            'berat_badan'  => ['nullable','integer','min:0','max:300'],
            'tinggi_badan' => ['nullable','integer','min:0','max:300'],

            'sekolah_asal' => ['nullable','string','max:150'],
            'tanggal_masuk_sekolah' => ['nullable','date'],
            'diterima_di_kelas'     => ['nullable','string','max:50'],

            'nama_ayah' => ['nullable','string','max:150'],
            'pekerjaan_ayah' => ['nullable','string','max:100'],
            'nama_ibu' => ['nullable','string','max:150'],
            'pekerjaan_ibu' => ['nullable','string','max:100'],
            'telepon_rumah' => ['nullable','string','max:30'],
            'alamat_orang_tua' => ['nullable','string'],

            'nama_wali' => ['nullable','string','max:150'],
            'pekerjaan_wali' => ['nullable','string','max:100'],
            'telepon_wali' => ['nullable','string','max:30'],
            'alamat_wali' => ['nullable','string'],
            ]);
        $student->update($data);
        return redirect()->route('students.index')->with('ok','Siswa diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('ok','Siswa dihapus.');
    }
}
