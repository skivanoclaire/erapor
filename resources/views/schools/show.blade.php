@extends('layouts.app')
@section('title', 'Profil Sekolah')
@section('content')
    <div class="grid md:grid-cols-3 gap-6">
        <section class="md:col-span-2 space-y-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Profil Sekolah</h2>
                <dl class="grid sm:grid-cols-2 gap-2 text-sm">
                    <div>
                        <dt class="text-slate-500">Nama</dt>
                        <dd class="font-medium">{{ $school->nama_sekolah }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Jenjang</dt>
                        <dd class="font-medium">{{ $school->jenjang }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">NPSN</dt>
                        <dd class="font-medium">{{ $school->npsn }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">NSS</dt>
                        <dd class="font-medium">{{ $school->nss }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Email</dt>
                        <dd class="font-medium">{{ $school->email }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-slate-500">Alamat</dt>
                        <dd class="font-medium">
                            {{ $school->alamat_jalan }}, {{ $school->desa_kelurahan }}, {{ $school->kecamatan }},
                            {{ $school->kabupaten_kota }}, {{ $school->provinsi }} {{ $school->kode_pos }}
                        </dd>
                    </div>
                </dl>
                <div class="mt-4">
                    <a href="{{ route('schools.edit', $school) }}"
                        class="inline-flex items-center rounded bg-blue-600 text-white px-3 py-2 text-sm hover:bg-blue-700">
                        Edit Profil
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Kepala Sekolah</h2>
                @if ($school->head)
                    <p class="text-sm">
                        <span class="font-medium">{{ $school->head->gelar_depan }} {{ $school->head->nama }}
                            {{ $school->head->gelar_belakang }}</span><br>
                        <span class="text-slate-500">NIP: {{ $school->head->nip ?? '-' }}</span>
                    </p>
                    <a href="{{ route('school-heads.edit', $school->head) }}"
                        class="text-blue-600 text-sm hover:underline">Edit Kepala Sekolah</a>
                @else
                    <p class="text-sm text-slate-500">Belum diisi.</p>
                @endif
            </div>
        </section>

        <aside class="space-y-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-semibold mb-3">Semester</h3>
                <ul class="space-y-2">
                    @foreach ($semesters as $sem)
                        <li class="flex items-center justify-between text-sm">
                            <div>
                                <div class="font-medium">{{ $sem->tahun_ajaran }} - {{ ucfirst($sem->semester) }}</div>
                                <div class="text-xs text-slate-500">Status: {{ $sem->status }}</div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('semesters.edit', $sem) }}"
                                    class="px-2 py-1 rounded border text-slate-700 hover:bg-slate-50">Edit</a>
                                @if ($activeSemester?->id !== $sem->id)
                                    <form method="POST" action="{{ route('semesters.activate', $sem) }}">
                                        @csrf @method('PATCH')
                                        <button
                                            class="px-2 py-1 rounded bg-emerald-600 text-white hover:bg-emerald-700">Aktifkan</button>
                                    </form>
                                @else
                                    <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700">Aktif</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('semesters.index') }}"
                    class="text-blue-600 text-xs hover:underline mt-2 inline-block">Lihat semua</a>
            </div>
        </aside>
    </div>
@endsection
