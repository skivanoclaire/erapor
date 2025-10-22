@extends('layouts.app')
@section('title', 'Siswa')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-lg">Siswa</h2>
            <a href="{{ route('students.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="mb-3 text-sm px-3 py-2 rounded bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter --}}
        <form method="GET" class="mb-3 flex flex-wrap gap-2">
            <input name="q" value="{{ $q }}" placeholder="Cari nama / NIS / NISN..."
                class="border rounded px-3 py-2 w-full sm:w-72">
            <select name="class_id" class="border rounded px-3 py-2">
                <option value="">Semua Kelas</option>
                @foreach ($classes as $id => $n)
                    <option value="{{ $id }}" @selected((string) $classId === (string) $id)>{{ $n }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 border rounded">Filter</button>
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr class="border-b">
                        <th class="py-2">NIS</th>
                        <th class="py-2">NISN</th>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Kelas</th>
                        <th class="py-2">Jenis Kelamin</th>
                        <th class="py-2">No. HP</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $s)
                        <tr class="border-t">
                            <td class="py-2">{{ $s->nis ?? '-' }}</td>
                            <td class="py-2">{{ $s->nisn ?? '-' }}</td>
                            <td class="py-2">{{ $s->nama }}</td>
                            <td class="py-2">{{ optional($s->class)->nama_kelas ?? '-' }}</td>
                            <td class="py-2">{{ $s->jk ?? '-' }}</td>
                            <td class="py-2">{{ $s->nomor_hp ?? '-' }}</td>
                            <td class="py-2 text-right space-x-1">
                                <a href="{{ route('students.edit', $s) }}"
                                    class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>

                                <form method="POST" action="{{ route('students.destroy', $s) }}" class="inline"
                                    onsubmit="return confirm('Hapus siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $students->withQueryString()->links() }}</div>
    </div>
@endsection
