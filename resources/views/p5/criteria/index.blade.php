@extends('layouts.app')
@section('title', 'Kriteria Projek')

@section('content')
    <div class="bg-white rounded-lg shadow p-4 max-w-4xl">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">
                Kriteria — {{ $p5->theme }} ({{ $p5->class->nama_kelas }})
            </h2>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('p5.criteria.reindex', $p5) }}" class="inline">
                    @csrf
                    <button class="px-3 py-2 border rounded text-sm hover:bg-slate-50">Rapikan Urutan</button>
                </form>
                <button class="px-3 py-2 border rounded text-sm hover:bg-slate-50"><a
                        href="{{ route('p5.ratings.index', $p5) }}" class="text-blue-600 text-sm hover:underline">Input Nilai
                        →</a></button>
            </div>
        </div>

        {{-- Flash & error --}}
        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form tambah kriteria --}}
        <form method="POST" action="{{ route('p5.criteria.store', $p5) }}" class="grid sm:grid-cols-6 gap-3 mb-4">
            @csrf
            <label class="text-sm sm:col-span-2">Urutan
                <input type="number" min="1" name="order_no" value="{{ old('order_no', $nextOrder ?? 1) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm sm:col-span-4">Judul / Deskripsi singkat
                <input name="title" value="{{ old('title') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <div class="sm:col-span-6">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Tambah Kriteria</button>
            </div>
        </form>

        {{-- Daftar kriteria --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th style="width:70px">Urut</th>
                        <th>Judul</th>
                        <th style="width:180px" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $r)
                        <tr class="border-t">
                            {{-- KOLOM URUT: nomor statis + tombol naik/turun --}}
                            <td class="py-2 align-middle">
                                <div class="flex items-center gap-1">
                                    <span class="w-8 inline-block text-center">{{ $r->order_no }}</span>

                                    <form method="POST" action="{{ route('p5.criteria.move', $r) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="dir" value="up">
                                        <button {{ $loop->first ? 'disabled' : '' }}
                                            class="px-2 py-1 border rounded {{ $loop->first ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-50' }}"
                                            title="Naik">↑</button>
                                    </form>

                                    <form method="POST" action="{{ route('p5.criteria.move', $r) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="dir" value="down">
                                        <button {{ $loop->last ? 'disabled' : '' }}
                                            class="px-2 py-1 border rounded {{ $loop->last ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-50' }}"
                                            title="Turun">↓</button>
                                    </form>
                                </div>
                            </td>

                            {{-- KOLOM JUDUL: edit judul saja --}}
                            <td class="py-2">
                                <form id="f-{{ $r->id }}" method="POST"
                                    action="{{ route('p5.criteria.update', $r) }}" class="flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <input name="title" value="{{ $r->title }}"
                                        class="flex-1 border rounded px-2 py-1">
                                    <button class="px-2 py-1 border rounded hover:bg-slate-50">Simpan</button>
                                </form>
                            </td>

                            <td class="py-2 text-right">
                                <form method="POST" action="{{ route('p5.criteria.destroy', $r) }}" class="inline"
                                    onsubmit="return confirm('Hapus kriteria ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>


            </table>
        </div>

        <p class="text-xs text-slate-500 mt-3">
            Tip: Gunakan tombol ↑/↓ untuk mengubah posisi cepat. Klik <em>Rapikan Urutan</em> bila perlu menormalkan kembali
            ke 1..n.
        </p>
    </div>
@endsection
