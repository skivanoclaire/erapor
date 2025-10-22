@extends('layouts.app')
@section('title', 'Edit Mapel')
@section('content')
    <form method="POST" action="{{ route('subjects.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit Mapel</h2>
        <label class="text-sm block mb-2">Short Name
            <input name="short_name" value="{{ old('short_name', $row->short_name) }}"
                class="mt-1 w-full border rounded px-3 py-2">
        </label>
        <label class="text-sm block mb-2">Nama
            <input name="name" value="{{ old('name', $row->name) }}" class="mt-1 w-full border rounded px-3 py-2">
        </label>
        <label class="text-sm block mb-2">Kelompok
            <input name="group" value="{{ old('group', $row->group) }}" class="mt-1 w-full border rounded px-3 py-2">
        </label>
        <label class="text-sm inline-flex items-center gap-2">
            <input type="checkbox" name="global_active" value="1" @checked($row->global_active)> Aktif?
        </label>
        <div class="mt-4"><button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('subjects.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
