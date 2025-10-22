@extends('layouts.app')
@section('title', 'Ekstrakurikuler')

@section('content')
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Ekstrakurikuler</h2>
            <a href="{{ route('extracurriculars.create') }}"
                class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Tambah</a>
        </div>

        {{-- Alerts (opsional) --}}
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

        <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
                <tr>
                    <th>Nama</th>
                    <th>Mentor</th>
                    <th>Aktif</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $r)
                    <tr class="border-t">
                        <td class="py-2">{{ $r->name }}</td>
                        <td class="py-2">{{ $r->mentor->nama ?? '-' }}</td>
                        <td class="py-2">
                            <span
                                class="px-2 py-1 rounded text-white text-xs {{ $r->active ? 'bg-emerald-600' : 'bg-slate-400' }}">
                                {{ $r->active ? 'ON' : 'OFF' }}
                            </span>
                        </td>
                        <td class="py-2 text-right">
                            {{-- Link anggota sesuai web.php --}}
                            <a href="{{ route('extracurriculars.members', $r) }}"
                                class="px-2 py-1 border rounded">Anggota</a>

                            {{-- Link nilai opsional (tampil bila route tersedia) --}}
                            @if (Route::has('ex.assess.index'))
                                <a href="{{ route('ex.assess.index', $r) }}" class="px-2 py-1 border rounded">Nilai</a>
                            @endif

                            <a href="{{ route('extracurriculars.edit', $r) }}" class="px-2 py-1 border rounded">Edit</a>

                            <form method="POST" action="{{ route('extracurriculars.destroy', $r) }}" class="inline"
                                onsubmit="return confirm('Hapus ekskul?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 rounded bg-rose-600 text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">{{ $rows->links() }}</div>
    </div>
@endsection
