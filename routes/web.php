<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolHeadController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\SubjectEnrollmentController;
use App\Http\Controllers\AssessmentTechniqueController;
use App\Http\Controllers\AssessmentPlanController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssessmentScoreController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ClassToolsController;
use App\Http\Controllers\P5ProjectController;
use App\Http\Controllers\P5MemberController;
use App\Http\Controllers\P5CriteriaController;
use App\Http\Controllers\P5RatingController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\ExtracurricularMemberController;
use App\Http\Controllers\ExtracurricularAssessmentController;
use App\Http\Controllers\PKLObjectiveController;
use App\Http\Controllers\PKLGroupController;
use App\Http\Controllers\PKLMemberController;
use App\Http\Controllers\PKLAssessmentController;
use App\Http\Controllers\CocurricularController;
use App\Http\Controllers\CocurricularMemberController;
use App\Http\Controllers\CocurricularAssessmentController;
use App\Http\Controllers\MediaUploadController;
use App\Http\Controllers\ReportDateController;
use App\Http\Controllers\AssessmentMonitorController;
use App\Http\Controllers\LeggerController;
use App\Http\Controllers\FinalGradeController;
use App\Http\Controllers\AssessmentBoardController;
use App\Http\Controllers\ReportPrintController;
use App\Http\Controllers\ReportDashboardController;
use App\Http\Controllers\ReportClassBoardController;
use App\Http\Controllers\PelengkapRaporController;
use App\Http\Controllers\AuthController;

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route logout (harus sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Home diarahkan ke profil sekolah pertama
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    // Redirect berdasarkan role
    switch ($user->jenis_ptk) {
        case 'kepala_sekolah':
        case 'operator':
            return redirect()->route('schools.show', 1);
        case 'guru':
        case 'guru_mapel':
            return redirect()->route('class-subjects.index');
        case 'pembina':
        case 'pembimbing_pkl':
            return redirect()->route('schools.show', 1);
        default:
            return redirect()->route('schools.show', 1);
    }
});

// Semua routes memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

// Routes untuk semua user yang sudah login (bisa lihat profil sekolah)
Route::resource('schools', SchoolController::class)->only(['show']);

// Routes yang bisa diakses guru/wali kelas
Route::get('class-subjects', [ClassSubjectController::class,'index'])->name('class-subjects.index');

// Guru bisa akses penilaian untuk mapel yang mereka ajar
Route::get('class-subjects/{cs}/enrollments', [SubjectEnrollmentController::class,'index'])->name('class-subjects.enrollments');
Route::get('class-subjects/{cs}/plan', [AssessmentPlanController::class,'edit'])->name('assessment-plans.edit');
Route::put('class-subjects/{cs}/plan', [AssessmentPlanController::class,'update'])->name('assessment-plans.update');
Route::get('class-subjects/{cs}/assessments', [AssessmentController::class,'index'])->name('assessments.index');
Route::post('class-subjects/{cs}/assessments', [AssessmentController::class,'store'])->name('assessments.store');
Route::get('assessments/{assessment}/edit', [AssessmentController::class,'edit'])->name('assessments.edit');
Route::put('assessments/{assessment}', [AssessmentController::class,'update'])->name('assessments.update');
Route::delete('assessments/{assessment}', [AssessmentController::class,'destroy'])->name('assessments.destroy');
Route::get('assessments/{assessment}/scores', [AssessmentScoreController::class,'edit'])->name('scores.edit');
Route::post('assessments/{assessment}/scores', [AssessmentScoreController::class,'update'])->name('scores.update');
Route::post('class-subjects/{cs}/compute-final', [AssessmentController::class,'computeFinal'])->name('assessments.compute-final');
Route::get('class-subjects/{cs}/final-grades', [FinalGradeController::class,'edit'])->name('class-subjects.final-grades.edit');
Route::post('class-subjects/{cs}/final-grades', [FinalGradeController::class,'update'])->name('class-subjects.final-grades.update');
Route::post('class-subjects/{cs}/final-grades/recompute', [FinalGradeController::class,'recompute'])->name('class-subjects.final-grades.recompute');
Route::get('class-subjects/{cs}/penilaian', [AssessmentBoardController::class,'board'])->name('assessments.board');
Route::post('class-subjects/{cs}/penilaian/assessments', [AssessmentBoardController::class,'storeAssessment'])->name('assessments.store');
Route::put('assessments/{asmt}', [AssessmentBoardController::class,'updateAssessment'])->name('assessments.update');
Route::delete('assessments/{asmt}', [AssessmentBoardController::class,'destroyAssessment'])->name('assessments.destroy');
Route::post('class-subjects/{cs}/penilaian/scores', [AssessmentBoardController::class,'saveScores'])->name('assessments.scores.save');
Route::post('class-subjects/{cs}/penilaian/recompute', [AssessmentBoardController::class,'recomputeFinal'])->name('assessments.recompute');

// Routes untuk semua user yang login (guru bisa akses)
Route::get('class-tools', [ClassToolsController::class,'index'])->name('class-tools.index');
Route::get('monitor-penilaian', [AssessmentMonitorController::class,'index'])->name('monitor-penilaian.index');
Route::get('daftar-legger', [LeggerController::class,'index'])->name('legger.index');

// P5BK - semua user bisa akses
Route::resource('p5-projects', P5ProjectController::class)->except(['show']);
Route::patch('p5-projects/{p5}/toggle', [P5ProjectController::class,'toggle'])->name('p5.toggle');
Route::get('p5-projects/{p5}/members', [P5MemberController::class,'index'])->name('p5.members');
Route::post('p5-projects/{p5}/members/enroll-all', [P5MemberController::class,'enrollAll'])->name('p5.members.enroll-all');
Route::post('p5-projects/{p5}/members', [P5MemberController::class,'store'])->name('p5.members.store');
Route::delete('p5-projects/{p5}/members/{student}', [P5MemberController::class,'destroy'])->name('p5.members.destroy');
Route::get('p5-projects/{p5}/criteria', [P5CriteriaController::class,'index'])->name('p5.criteria');
Route::post('p5-projects/{p5}/criteria', [P5CriteriaController::class,'store'])->name('p5.criteria.store');
Route::put('p5-criteria/{crit}', [P5CriteriaController::class,'update'])->name('p5.criteria.update');
Route::delete('p5-criteria/{crit}', [P5CriteriaController::class,'destroy'])->name('p5.criteria.destroy');
Route::get('p5-projects/{p5}/ratings', [P5RatingController::class,'index'])->name('p5.ratings.index');
Route::get('p5-projects/{p5}/ratings/{student}', [P5RatingController::class,'edit'])->name('p5.ratings.edit');
Route::post('p5-projects/{p5}/ratings/{student}', [P5RatingController::class,'update'])->name('p5.ratings.update');
Route::patch('p5-criteria/{crit}/move', [P5CriteriaController::class,'move'])->name('p5.criteria.move');
Route::post('p5-projects/{p5}/criteria/reindex', [P5CriteriaController::class,'reindex'])->name('p5.criteria.reindex');

// Ekstrakurikuler - semua user bisa akses
Route::resource('extracurriculars', ExtracurricularController::class)->except(['show']);
Route::get('extracurriculars/{ex}/members', [ExtracurricularMemberController::class,'index'])->name('ex.members');
Route::post('extracurriculars/{ex}/members', [ExtracurricularMemberController::class,'store'])->name('ex.members.store');
Route::post('extracurriculars/{ex}/members/add-all', [ExtracurricularMemberController::class,'storeAll'])->name('ex.members.storeAll');
Route::delete('extracurriculars/{ex}/members/{member}', [ExtracurricularMemberController::class,'destroy'])->name('ex.members.destroy');
Route::get('extracurriculars/{ex}/assessments', [ExtracurricularAssessmentController::class,'index'])->name('ex.assess.index');
Route::post('extracurriculars/{ex}/assessments', [ExtracurricularAssessmentController::class,'store'])->name('ex.assess.store');

// PKL - semua user bisa akses
Route::resource('pkl-objectives', PKLObjectiveController::class)->except(['show']);
Route::resource('pkl-groups', PKLGroupController::class)->except(['show']);
Route::get('pkl-groups/{group}/members', [PKLMemberController::class,'index'])->name('pkl.members');
Route::post('pkl-groups/{group}/members/enroll-class', [PKLMemberController::class,'enrollClass'])->name('pkl.members.enroll-class');
Route::post('pkl-groups/{group}/members', [PKLMemberController::class,'store'])->name('pkl.members.store');
Route::delete('pkl-groups/{group}/members/{student}', [PKLMemberController::class,'destroy'])->name('pkl.members.destroy');
Route::get('pkl-groups/{group}/assess', [PKLAssessmentController::class,'index'])->name('pkl.assess.index');
Route::post('pkl-groups/{group}/assess', [PKLAssessmentController::class,'store'])->name('pkl.assess.store');

// Kokurikuler - semua user bisa akses
Route::resource('cocurriculars', CocurricularController::class)->except(['show']);
Route::get('cocurriculars/{co}/members', [CocurricularMemberController::class,'index'])->name('co.members');
Route::post('cocurriculars/{co}/members/enroll-class', [CocurricularMemberController::class,'enrollClass'])->name('co.members.enroll-class');
Route::post('cocurriculars/{co}/members', [CocurricularMemberController::class,'store'])->name('co.members.store');
Route::delete('cocurriculars/{co}/members/{student}', [CocurricularMemberController::class,'destroy'])->name('co.members.destroy');
Route::get('cocurriculars/{co}/assess', [CocurricularAssessmentController::class,'index'])->name('co.assess.index');
Route::post('cocurriculars/{co}/assess', [CocurricularAssessmentController::class,'store'])->name('co.assess.store');

// Attendance, Notes, Promotions - semua user bisa akses
Route::get('classes/{class}/semesters/{semester}/attendance', [AttendanceController::class,'edit'])->name('attendance.edit');
Route::post('classes/{class}/semesters/{semester}/attendance', [AttendanceController::class,'update'])->name('attendance.update');
Route::get('classes/{class}/semesters/{semester}/notes', [NoteController::class,'edit'])->name('notes.edit');
Route::post('classes/{class}/semesters/{semester}/notes', [NoteController::class,'update'])->name('notes.update');
Route::get('classes/{class}/semesters/{semester}/promotions', [PromotionController::class,'index'])->name('promotions.index');
Route::post('classes/{class}/semesters/{semester}/promotions', [PromotionController::class,'store'])->name('promotions.store');

// Routes khusus untuk kepala_sekolah dan operator (administrasi)
Route::middleware(['role:kepala_sekolah,operator'])->group(function () {

Route::resource('schools', SchoolController::class)->only(['edit', 'update']);
Route::resource('school-heads', SchoolHeadController::class)->only(['edit', 'update']);

Route::get('semesters', [SemesterController::class, 'index'])->name('semesters.index');
Route::get('semesters/create', [SemesterController::class, 'create'])->name('semesters.create');
Route::post('semesters', [SemesterController::class, 'store'])->name('semesters.store');
Route::get('semesters/{semester}/edit', [SemesterController::class, 'edit'])->name('semesters.edit');
Route::put('semesters/{semester}', [SemesterController::class, 'update'])->name('semesters.update');
Route::patch('semesters/{semester}/activate', [SemesterController::class, 'activate'])->name('semesters.activate');
Route::resource('users', UserController::class)->except(['show']);
Route::resource('classes', ClassroomController::class)->except(['show']);
Route::resource('students', StudentController::class)->except(['show']);

Route::resource('subjects', SubjectController::class)->except(['show']);

Route::get('class-subjects/create', [ClassSubjectController::class,'create'])->name('class-subjects.create');
Route::post('class-subjects', [ClassSubjectController::class,'store'])->name('class-subjects.store');
Route::get('class-subjects/{cs}/edit', [ClassSubjectController::class,'edit'])->name('class-subjects.edit');
Route::put('class-subjects/{cs}', [ClassSubjectController::class,'update'])->name('class-subjects.update');
Route::delete('class-subjects/{cs}', [ClassSubjectController::class,'destroy'])->name('class-subjects.destroy');
Route::patch('class-subjects/{cs}/toggle', [ClassSubjectController::class,'toggle'])->name('class-subjects.toggle');

Route::post('class-subjects/{cs}/enroll-all', [SubjectEnrollmentController::class,'enrollAll'])->name('class-subjects.enroll-all');
Route::post('class-subjects/{cs}/enrollments', [SubjectEnrollmentController::class,'store'])->name('class-subjects.enrollments.store');
Route::delete('class-subjects/{cs}/enrollments/{student}', [SubjectEnrollmentController::class,'destroy'])->name('class-subjects.enrollments.destroy');

// Teknik penilaian (CRUD)
Route::resource('assessment-techniques', AssessmentTechniqueController::class)->except(['show']);

// Media Uploads (index, store, destroy)
Route::get   ('media',            [MediaUploadController::class, 'index'])->name('media.index');
Route::post  ('media',            [MediaUploadController::class, 'store'])->name('media.store');
Route::delete('media/{media}',    [MediaUploadController::class, 'destroy'])->name('media.destroy');

// Report Dates (Tanggal Rapor)
Route::get   ('report-dates',                              [ReportDateController::class,'index'])->name('rdate.index');
Route::get   ('report-dates/create',                       [ReportDateController::class,'create'])->name('rdate.create');
Route::post  ('report-dates',                              [ReportDateController::class,'store'])->name('rdate.store');
Route::get   ('report-dates/{rdate}/edit',                 [ReportDateController::class,'edit'])->name('rdate.edit');
Route::put   ('report-dates/{rdate}',                      [ReportDateController::class,'update'])->name('rdate.update');
Route::delete('report-dates/{rdate}',                      [ReportDateController::class,'destroy'])->name('rdate.destroy');


Route::prefix('reports')->group(function () {
    // Preview HTML satu siswa
    Route::get('semester/{student}/{semester}', [ReportPrintController::class, 'show'])
        ->name('reports.semester.show');

    // Unduh PDF
    Route::get('semester/{student}/{semester}/pdf', [ReportPrintController::class, 'pdf'])
        ->name('reports.semester.pdf');
});

}); // End of kepala_sekolah & operator role middleware

// Routes untuk semua authenticated users (guru bisa akses rapor)
Route::get('rapor/dashboard', [ReportDashboardController::class, 'index'])
    ->name('reports.dashboard');

Route::get('rapor/kelas', [ReportClassBoardController::class, 'index'])
    ->name('reports.class-board');


Route::get('/rapor/pelengkap/{student}/pdf',
[PelengkapRaporController::class, 'pdf']
)->name('rapor.pelengkap.pdf');

Route::get('/rapor/mid/{student}/{semester}', [\App\Http\Controllers\MidReportController::class, 'show'])
     ->name('rapor.mid.show');

Route::get('/rapor/mid/{student}/{semester}/pdf', [\App\Http\Controllers\MidReportController::class, 'pdf'])
     ->name('rapor.mid.pdf');

Route::get('/rapor/p5/{student}/{semester}', [\App\Http\Controllers\P5ReportController::class, 'show'])
     ->name('rapor.p5.show');

Route::get('/rapor/p5/{student}/{semester}/pdf', [\App\Http\Controllers\P5ReportController::class, 'pdf'])
     ->name('rapor.p5.pdf');

Route::get('/rapor/buku-induk/{student}', [\App\Http\Controllers\BookReportController::class, 'show'])
     ->name('rapor.buku_induk.show');

Route::get('/rapor/buku-induk/{student}/pdf', [\App\Http\Controllers\BookReportController::class, 'pdf'])
     ->name('rapor.buku_induk.pdf');

}); // End of auth middleware group