@extends('layouts.app')
@section('title', 'Media Uploads')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Pusat Berkas</h2>
        </div>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" class="mb-3 flex gap-2">
            <select name="school_id" class="border rounded px-3 py-2" onchange="this.form.submit()">
                <option value="">Semua Sekolah</option>
                @foreach ($schools as $id => $n)
                    <option value="{{ $id }}" @selected(($schoolId ?? '') == $id)>{{ $n }}</option>
                @endforeach
            </select>
        </form>

        <form method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data"
            class="mb-4 flex flex-wrap items-end gap-2">
            @csrf
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(($schoolId ?? '') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Berkas
                <input type="file" name="file" class="mt-1 border rounded px-3 py-2">
            </label>
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Upload</button>
            <div class="text-xs text-slate-500">jpg, png, webp, svg, pdf; maks 2MB.</div>
        </form>

        <div class="grid sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($rows as $m)
                <div class="border rounded-lg p-3">
                    <div class="h-28 flex items-center justify-center bg-slate-50 rounded mb-2 overflow-hidden">
                        @if (Str::startsWith($m->mime, 'image/'))
                            <img src="{{ asset('storage/' . $m->path) }}" alt="" class="max-h-28">
                        @else
                            <div class="text-xs text-slate-600">{{ strtoupper(pathinfo($m->path, PATHINFO_EXTENSION)) }}
                                file</div>
                        @endif
                    </div>
                    <div class="text-sm font-medium truncate">{{ $m->filename() }}</div>
                    <div class="text-xs text-slate-500 truncate">{{ $m->school->nama_sekolah ?? '' }}</div>
                    <div class="mt-2 flex items-center justify-between">
                        <a class="text-blue-600 text-xs hover:underline" href="{{ asset('storage/' . $m->path) }}"
                            target="_blank">Lihat</a>
                        <form method="POST" action="{{ route('media.destroy', $m) }}"
                            onsubmit="return confirm('Hapus berkas ini?')">
                            @csrf @method('DELETE')
                            <button class="text-rose-600 text-xs">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
@endsection
