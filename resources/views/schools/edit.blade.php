@extends('layouts.app')
@section('title', 'Edit Profil Sekolah')
@section('content')
    <form method="POST" action="{{ route('schools.update', $school) }}" class="bg-white rounded-lg shadow p-4 max-w-3xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit Profil Sekolah</h2>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Nama Sekolah
                <input name="nama_sekolah" value="{{ old('nama_sekolah', $school->nama_sekolah) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Email
                <input name="email" type="email" value="{{ old('email', $school->email) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Website
                <input name="website" value="{{ old('website', $school->website) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Telepon
                <input name="telepon" value="{{ old('telepon', $school->telepon) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm sm:col-span-2">Alamat Jalan
                <input name="alamat_jalan" value="{{ old('alamat_jalan', $school->alamat_jalan) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Desa/Kelurahan
                <input name="desa_kelurahan" value="{{ old('desa_kelurahan', $school->desa_kelurahan) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Kecamatan
                <input name="kecamatan" value="{{ old('kecamatan', $school->kecamatan) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Kab/Kota
                <input name="kabupaten_kota" value="{{ old('kabupaten_kota', $school->kabupaten_kota) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Provinsi
                <input name="provinsi" value="{{ old('provinsi', $school->provinsi) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Kode Pos
                <input name="kode_pos" value="{{ old('kode_pos', $school->kode_pos) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">NPSN
                <input name="npsn" value="{{ old('npsn', $school->npsn) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">NSS
                <input name="nss" value="{{ old('nss', $school->nss) }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">Simpan</button>
            <a href="{{ route('schools.show', $school) }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
