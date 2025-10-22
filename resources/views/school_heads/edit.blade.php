@extends('layouts.app')
@section('title', 'Kepala Sekolah')

@section('content')
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl">
        <h2 class="font-semibold mb-4">Edit Kepala Sekolah</h2>

        @if (session('ok'))
            <div class="mb-3 rounded border border-emerald-200 bg-emerald-50 text-emerald-800 px-3 py-2 text-sm">
                {{ session('ok') }}
            </div>
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

        <div class="mb-4 text-sm text-slate-600">
            Sekolah:
            <b>{{ optional($head->school)->nama_sekolah ?? '—' }}</b>
        </div>

        <form method="POST" action="{{ route('school-heads.update', $head) }}" x-data="{
            depan: @js(old('gelar_depan', $head->gelar_depan)),
            nama: @js(old('nama', $head->nama)),
            belakang: @js(old('gelar_belakang', $head->gelar_belakang)),
            full() { return [this.depan, this.nama, this.belakang].filter(Boolean).join(' ').replace(/\s+/g, ' ').trim(); }
        }">
            @csrf @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <label class="text-sm">NIP
                    <input name="nip" value="{{ old('nip', $head->nip) }}" class="mt-1 w-full border rounded px-3 py-2"
                        maxlength="30">
                </label>

                <div></div>

                <label class="text-sm">Gelar Depan
                    <input name="gelar_depan" x-model="depan" value="{{ old('gelar_depan', $head->gelar_depan) }}"
                        class="mt-1 w-full border rounded px-3 py-2" maxlength="50" placeholder="Dr., H., Ir., dll">
                </label>

                <label class="text-sm">Gelar Belakang
                    <input name="gelar_belakang" x-model="belakang"
                        value="{{ old('gelar_belakang', $head->gelar_belakang) }}"
                        class="mt-1 w-full border rounded px-3 py-2" maxlength="50" placeholder="S.Pd., M.Pd., dll">
                </label>

                <label class="text-sm sm:col-span-2">Nama
                    <input name="nama" x-model="nama" value="{{ old('nama', $head->nama) }}"
                        class="mt-1 w-full border rounded px-3 py-2" maxlength="150" required>
                </label>
            </div>

            <div class="mt-3 text-sm text-slate-600">
                Pratinjau nama lengkap: <b x-text="full()"></b>
            </div>

            <div class="mt-4">
                <button class="rounded bg-blue-600 text-white px-4 py-2">Simpan</button>
                @php
                    $backUrl = optional($head->school)->id
                        ? route('schools.show', optional($head->school)->id)
                        : route('schools.index');
                @endphp
                <a href="{{ $backUrl }}" class="px-4 py-2 border rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection
