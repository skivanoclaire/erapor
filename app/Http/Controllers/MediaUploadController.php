<?php
namespace App\Http\Controllers;

use App\Models\{MediaUpload,School};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaUploadController extends Controller
{
    public function index(Request $r)
    {
        $schoolId = $r->get('school_id');
        $schools = School::orderBy('nama_sekolah')->pluck('nama_sekolah','id');

        $rows = MediaUpload::with('school')
            ->when($schoolId, fn($q)=>$q->where('school_id',$schoolId))
            ->orderByDesc('id')->paginate(24)->withQueryString();

        return view('media.index', compact('rows','schools','schoolId'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'school_id' => ['required','exists:schools,id'],
            'file'      => ['required','file','mimes:jpg,jpeg,png,webp,svg,pdf','max:2048'],
        ]);

        $path = $r->file('file')->store('uploads/'.$data['school_id'], 'public');
        MediaUpload::create([
            'school_id'=>$data['school_id'],
            'path'=>$path,
            'mime'=>$r->file('file')->getClientMimeType(),
            'size'=>$r->file('file')->getSize(),
        ]);

        return back()->with('ok','Berkas diunggah.');
    }

    public function destroy(MediaUpload $media)
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();
        return back()->with('ok','Berkas dihapus.');
    }
}
