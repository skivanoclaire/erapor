@extends('layouts.app')
@section('title', 'Catatan Wali/Guru')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold mb-2">Catatan — {{ $class->nama_kelas }} / {{ $semester->tahun_ajaran }}
            ({{ $semester->semester }})</h2>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif

        <form method="POST" action="{{ route('notes.update', [$class, $semester]) }}">
            @csrf
            <div class="space-y-4">
                @foreach ($students as $s)
                    @php $r = $map[$s->id] ?? null; @endphp
                    <div class="border rounded p-3">
                        <div class="font-medium">{{ $s->nama }}</div>
                        <div class="grid md:grid-cols-2 gap-3 mt-2">
                            <label class="text-sm">Catatan Tengah Semester
                                <textarea name="ct[{{ $s->id }}]" rows="3" class="mt-1 w-full border rounded px-3 py-2">{{ $r->catatan_tengah ?? '' }}</textarea>
                            </label>
                            <label class="text-sm">Catatan Akhir Semester
                                <textarea name="ca[{{ $s->id }}]" rows="3" class="mt-1 w-full border rounded px-3 py-2">{{ $r->catatan_akhir ?? '' }}</textarea>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="ids[]" value="{{ $s->id }}">
                @endforeach
            </div>
            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan Catatan</button>
            </div>
        </form>
    </div>
@endsection
