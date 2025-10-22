@extends('layouts.app')
@section('title', 'Nilai P5BK')

@section('content')
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl">
        <h2 class="font-semibold mb-3">Nilai — {{ $p5->theme }} ({{ $p5->class->nama_kelas }})</h2>
        <ul class="divide-y">
            @forelse($students as $s)
                <li class="py-2 flex items-center justify-between">
                    <span>{{ $s->nama }}</span>
                    <a class="px-3 py-1 border rounded hover:bg-slate-50"
                        href="{{ route('p5.ratings.edit', [$p5, $s->id]) }}">Input Nilai</a>
                </li>
            @empty
                <li class="py-2 text-slate-500">Belum ada anggota projek.</li>
            @endforelse
        </ul>
    </div>
@endsection
