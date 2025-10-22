@extends('layouts.app')
@section('title', 'Edit Pengaturan Rapor')

@section('content')
    <form method="POST" action="{{ route('report-settings.update', $row) }}" class="bg-white rounded-lg shadow p-4 max-w-4xl">
        @csrf @method('PUT')
        <h2 class="font-semibold mb-4">Edit Pengaturan Rapor</h2>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}" @selected(old('school_id', $row->school_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Semester
                <select name="semester_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($semesters as $id => $n)
                        <option value="{{ $id }}" @selected(old('semester_id', $row->semester_id) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Jenis Kertas
                <select name="jenis_kertas" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach (['A4', 'F4', 'Letter'] as $k)
                        <option value="{{ $k }}" @selected(old('jenis_kertas', $row->jenis_kertas) == $k)>{{ $k }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Margin Atas (cm)
                <input type="number" step="0.1" min="0" max="10" name="margin_top_cm"
                    value="{{ old('margin_top_cm', $row->margin_top_cm) }}" class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Format Nama Siswa
                <select name="format_penulisan_nama" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach (['Data Asli', 'Huruf Kapital', 'Title Case'] as $f)
                        <option value="{{ $f }}" @selected(old('format_penulisan_nama', $row->format_penulisan_nama) == $f)>{{ $f }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Judul Rapor
                <input name="judul_rapor" value="{{ old('judul_rapor', $row->judul_rapor) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Tempat Cetak
                <input name="tempat_cetak" value="{{ old('tempat_cetak', $row->tempat_cetak) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Nama Kementerian
                <input name="nama_kementerian" value="{{ old('nama_kementerian', $row->nama_kementerian) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <label class="text-sm">Label ID Wali
                <input name="label_id_wali" value="{{ old('label_id_wali', $row->label_id_wali) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Label ID Kepsek
                <input name="label_id_kepsek" value="{{ old('label_id_kepsek', $row->label_id_kepsek) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Label ID Siswa (footer)
                <input name="label_id_siswa_footer" value="{{ old('label_id_siswa_footer', $row->label_id_siswa_footer) }}"
                    class="mt-1 w-full border rounded px-3 py-2">
            </label>

            <div class="text-sm flex items-center gap-3">
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="tampilkan_nilai_desimal"
                        value="1" @checked(old('tampilkan_nilai_desimal', $row->tampilkan_nilai_desimal))> Nilai desimal?</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="tampilkan_keputusan"
                        value="1" @checked(old('tampilkan_keputusan', $row->tampilkan_keputusan))> Tampilkan keputusan?</label>
            </div>

            <div class="text-sm flex items-center gap-3">
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="p5_on_new_page" value="1"
                        @checked(old('p5_on_new_page', $row->p5_on_new_page))> P5BK halaman baru</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="ekskul_on_new_page"
                        value="1" @checked(old('ekskul_on_new_page', $row->ekskul_on_new_page))> Ekskul halaman baru</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="catatan_on_new_page"
                        value="1" @checked(old('catatan_on_new_page', $row->catatan_on_new_page))> Catatan halaman baru</label>
            </div>

            <label class="text-sm sm:col-span-2">TTD Kepala Sekolah (Media)
                <select name="ttd_kepsek_media_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($media as $m)
                        <option value="{{ $m->id }}" @selected(old('ttd_kepsek_media_id', $row->ttd_kepsek_media_id) == $m->id)>{{ $m->filename() }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm sm:col-span-2">Logo Pemda (Media)
                <select name="logo_pemda_media_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($media as $m)
                        <option value="{{ $m->id }}" @selected(old('logo_pemda_media_id', $row->logo_pemda_media_id) == $m->id)>{{ $m->filename() }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm sm:col-span-2">Logo Sekolah (Media)
                <select name="logo_sekolah_media_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">-</option>
                    @foreach ($media as $m)
                        <option value="{{ $m->id }}" @selected(old('logo_sekolah_media_id', $row->logo_sekolah_media_id) == $m->id)>{{ $m->filename() }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="mt-4">
            <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
            <a href="{{ route('report-settings.index') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
