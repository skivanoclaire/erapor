<?php
// app/Http/Controllers/ClassToolsController.php
namespace App\Http\Controllers;

use App\Models\{SchoolClass, Semester};
use Illuminate\Http\Request;

class ClassToolsController extends Controller
{
    public function index(Request $r)
    {
        $classes   = SchoolClass::orderBy('tingkat_pendidikan')->orderBy('nama_kelas')
                      ->pluck('nama_kelas','id');
        $semesters = Semester::orderByDesc('id')->get()
                      ->mapWithKeys(fn($s)=>[$s->id => $s->tahun_ajaran.' ('.$s->semester.')']);

        // support preselect via query (?class_id=1&semester_id=2)
        $classId    = $r->get('class_id');
        $semesterId = $r->get('semester_id');

        return view('class_tools.index', compact('classes','semesters','classId','semesterId'));
    }
}
