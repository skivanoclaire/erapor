@extends('layouts.app')
@section('title', 'Tambah Kelas')

@section('content')
    <form method="POST" action="{{ route('classes.store') }}" class="bg-white rounded-lg shadow p-4 max-w-xl">
        @csrf
        <h2 class="font-semibold mb-4">Tambah Kelas</h2>

        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Nama Kelas
                <input name="nama_kelas" class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Jurusan
                <input name="jurusan" value="{{ old('jurusan') }}" class="mt-1 w-full border rounded px-3 py-2"
                    placeholder="mis. TKJ, DKV, TBSM">
            </label>

            <label class="text-sm">Tingkat Pendidikan
                <input name="tingkat_pendidikan" placeholder="10/11/12" class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Wali Kelas
                <select name="wali_kelas_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($walies as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('classes.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
