@extends('layouts.app')
@section('title', 'Semester')
@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold">Daftar Semester</h2>
            <a href="{{ route('semesters.create') }}"
               class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                + Tambah Semester Baru
            </a>
        </div>

        @if(session('ok'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('ok') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">Sekolah</th>
                        <th class="py-2">Tahun Ajaran</th>
                        <th class="py-2">Semester</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semesters as $sem)
                        <tr class="border-t">
                            <td class="py-2">{{ $sem->school->nama_sekolah }}</td>
                            <td class="py-2">{{ $sem->tahun_ajaran }}</td>
                            <td class="py-2 capitalize">{{ $sem->semester }}</td>
                            <td class="py-2">
                                <span
                                    class="px-2 py-1 rounded text-xs {{ $sem->status === 'berjalan' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $sem->status }}
                                </span>
                            </td>
                            <td class="py-2 text-right">
                                <a href="{{ route('semesters.edit', $sem) }}"
                                    class="px-2 py-1 border rounded hover:bg-slate-50">Edit</a>
                                @if ($sem->status !== 'berjalan')
                                    <form class="inline" method="POST" action="{{ route('semesters.activate', $sem) }}">
                                        @csrf @method('PATCH')
                                        <button
                                            class="px-2 py-1 rounded bg-emerald-600 text-white hover:bg-emerald-700">Aktifkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $semesters->links() }}</div>
    </div>
@endsection
