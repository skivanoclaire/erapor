@extends('layouts.app')
@section('title', 'Tambah Siswa')

@section('content')
    <form method="POST" action="{{ route('students.store') }}" class="bg-white rounded-lg shadow p-4">
        @csrf
        <h2 class="font-semibold mb-4 text-lg">Tambah Siswa</h2>

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="mb-4 text-sm px-3 py-2 rounded bg-rose-50 text-rose-700 border border-rose-200">
                <b>Periksa kembali isian Anda.</b>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Sekolah & Kelas --}}
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2" required>
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(old('school_id') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Kelas
                <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(old('class_id') == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Identitas dasar --}}
            <label class="text-sm">NIS
                <input name="nis" value="{{ old('nis') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">NISN
                <input name="nisn" value="{{ old('nisn') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">NIK
                <input name="nik" value="{{ old('nik') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Nama
                <input name="nama" value="{{ old('nama') }}" class="mt-1 w-full border rounded px-3 py-2" required>
            </label>
            <label class="text-sm">Jenis Kelamin
                <select name="jk" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="L" @selected(old('jk') === 'L')>L</option>
                    <option value="P" @selected(old('jk') === 'P')>P</option>
                </select>
            </label>
            <label class="text-sm">Tempat Lahir
                <input name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Tanggal Lahir
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Agama
                <input name="agama" value="{{ old('agama') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Status dalam Keluarga
                <input name="status_dalam_keluarga" value="{{ old('status_dalam_keluarga') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Anak ke
                <input type="number" name="anak_ke" value="{{ old('anak_ke') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Alamat & Kontak --}}
            <label class="text-sm md:col-span-2">Alamat Peserta Didik
                <textarea name="alamat" rows="2" class="mt-1 w-full border rounded px-3 py-2">{{ old('alamat') }}</textarea>
            </label>
            <label class="text-sm">Telepon Rumah
                <input name="telepon_rumah" value="{{ old('telepon_rumah') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">No. HP
                <input name="nomor_hp" value="{{ old('nomor_hp') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">No. Rumah
                <input name="nomor_rumah" value="{{ old('nomor_rumah') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Fisik --}}
            <label class="text-sm">Berat Badan (kg)
                <input type="number" name="berat_badan" value="{{ old('berat_badan') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Tinggi Badan (cm)
                <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Riwayat --}}
            <label class="text-sm">Sekolah Asal
                <input name="sekolah_asal" value="{{ old('sekolah_asal') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Tanggal Masuk Sekolah
                <input type="date" name="tanggal_masuk_sekolah" value="{{ old('tanggal_masuk_sekolah') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Diterima di Kelas
                <input name="diterima_di_kelas" value="{{ old('diterima_di_kelas') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            {{-- Orang tua --}}
            <label class="text-sm">Nama Ayah
                <input name="nama_ayah" value="{{ old('nama_ayah') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Pekerjaan Ayah
                <input name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Nama Ibu
                <input name="nama_ibu" value="{{ old('nama_ibu') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Pekerjaan Ibu
                <input name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm md:col-span-2">Alamat Orang Tua
                <textarea name="alamat_orang_tua" rows="2" class="mt-1 w-full border rounded px-3 py-2">{{ old('alamat_orang_tua') }}</textarea>
            </label>

            {{-- Wali --}}
            <label class="text-sm">Nama Wali
                <input name="nama_wali" value="{{ old('nama_wali') }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Pekerjaan Wali
                <input name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Telepon Wali
                <input name="telepon_wali" value="{{ old('telepon_wali') }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm md:col-span-2">Alamat Wali
                <textarea name="alamat_wali" rows="2" class="mt-1 w-full border rounded px-3 py-2">{{ old('alamat_wali') }}</textarea>
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('students.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
