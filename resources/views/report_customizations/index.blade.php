@extends('layouts.app')
@section('title', 'Kustom Font Rapor')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Kustom Font & Ukuran</h2>
            <a href="{{ route('rc.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <form method="GET" class="mb-3 flex gap-2">
            <select name="school_id" class="border rounded px-3 py-2">
                <option value="">Semua Sekolah</option>
                @foreach ($schools as $id => $n)
                    <option value="{{ $id }}" @selected(($schoolId ?? '') == $id)>{{ $n }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Sekolah</th>
                    <th>Berlaku untuk</th>
                    <th>Font</th>
                    <th>Judul/Head/Body</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->school->nama_sekolah ?? '-' }}</td>
                        <td class="py-2">{{ $r->apply_to }}</td>
                        <td class="py-2">{{ $r->font_family }}</td>
                        <td class="py-2">{{ $r->title_font_size }} / {{ $r->table_header_font_size }} /
                            {{ $r->table_body_font_size }}</td>
                        <td class="py-2 text-right">
                            <a href="{{ route('rc.edit', $r) }}" class="px-2 py-1 border rounded">Edit</a>
                            <form method="POST" action="{{ route('rc.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus kustom ini?')">
                                @csrf @method('DELETE') <button
                                    class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
@endsection
