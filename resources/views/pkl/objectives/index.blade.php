@extends('layouts.app')
@section('title', 'Tujuan PKL')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Tujuan PKL</h2>
            <a href="{{ route('pkl-objectives.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Judul</th>
                    <th>Desskripsi</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->title }}</td>
                        <td class="py-2">{{ $r->description }}</td>
                        <td class="py-2 text-right">
                            <a href="{{ route('pkl-objectives.edit', $r) }}" class="px-2 py-1 border rounded">Edit</a>
                            <form method="POST" action="{{ route('pkl-objectives.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus tujuan?')">
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
