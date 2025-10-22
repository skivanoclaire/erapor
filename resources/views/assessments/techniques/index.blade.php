@extends('layouts.app')
@section('title', 'Teknik Penilaian')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Teknik Penilaian</h2>
            <a href="{{ route('assessment-techniques.create') }}"
                class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>
        <form method="GET" class="mb-3">
            <input name="q" value="{{ $q }}" placeholder="Cari nama/short..."
                class="border rounded px-3 py-2 w-full sm:w-64">
        </form>
        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Short</th>
                    <th>Nama</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->short_name }}</td>
                        <td class="py-2">{{ $r->name }}</td>
                        <td class="py-2 text-right">
                            <a href="{{ route('assessment-techniques.edit', $r) }}"
                                class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                            <form method="POST" action="{{ route('assessment-techniques.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus teknik?')">
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
