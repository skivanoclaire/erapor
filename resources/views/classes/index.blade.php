@extends('layouts.app')
@section('title', 'Kelas')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Kelas</h2>
            <a href="{{ route('classes.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <form method="GET" class="mb-3">
            <input name="q" value="{{ $q }}" placeholder="Cari nama kelas..."
                class="border rounded px-3 py-2 w-full sm:w-64">
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Jurusan</th>
                        <th>Tingkat</th>
                        <th>Wali</th>
                        <th>Jumlah Siswa</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $c)
                        <tr class="border-t">
                            <td class="py-2">{{ $c->nama_kelas }}</td>
                            <td>{{ $c->jurusan ?? '-' }}</td>
                            <td class="py-2">{{ $c->tingkat_pendidikan }}</td>
                            <td class="py-2">{{ $c->wali->nama ?? '-' }}</td>
                            <td class="py-2">{{ $c->students_count }}</td>
                            <td class="py-2 text-right">
                                <a href="{{ route('classes.edit', $c) }}"
                                    class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                                <form method="POST" action="{{ route('classes.destroy', $c) }}" class="inline"
                                    onsubmit="return confirm('Hapus kelas?')">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $classes->links() }}</div>
    </div>
@endsection
