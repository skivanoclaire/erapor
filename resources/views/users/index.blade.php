@extends('layouts.app')
@section('title', 'Users')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Users</h2>
            <a href="{{ route('users.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <form method="GET" class="mb-3">
            <input name="q" value="{{ $q }}" placeholder="Cari nama/username..."
                class="border rounded px-3 py-2 w-full sm:w-64">
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>PTK</th>
                        <th>Sekolah</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr class="border-t">
                            <td class="py-2">{{ $u->nama }}</td>
                            <td class="py-2">{{ $u->username }}</td>
                            <td class="py-2">{{ $u->jenis_ptk }}</td>
                            <td class="py-2">{{ $u->school->nama_sekolah ?? '-' }}</td>
                            <td class="py-2 text-right">
                                <a href="{{ route('users.edit', $u) }}"
                                    class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                                <form method="POST" action="{{ route('users.destroy', $u) }}" class="inline"
                                    onsubmit="return confirm('Hapus user?')">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links() }}</div>
    </div>
@endsection
