@extends('layouts.app')
@section('title', 'Aksi Kelas')

@section('content')
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl">
        <h2 class="font-semibold mb-4">Aksi Kelas</h2>

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Semester
                <select id="sem_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($semesters as $id => $label)
                        <option value="{{ $id }}" @selected(($semesterId ?? null) == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="text-sm">Kelas
                <select id="class_id" class="mt-1 w-full border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($classes as $id => $n)
                        <option value="{{ $id }}" @selected(($classId ?? null) == $id)>{{ $n }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <button onclick="go('attendance')" class="px-4 py-2 rounded bg-blue-600 text-white">Absensi</button>
            <button onclick="go('notes')" class="px-4 py-2 rounded bg-sky-600 text-white">Catatan</button>
            <button onclick="go('promotions')" class="px-4 py-2 rounded bg-emerald-600 text-white">Kenaikan Kelas</button>
        </div>

        <p class="text-xs text-slate-500 mt-3">Pilih Semester dan Kelas, lalu klik salah satu aksi.</p>
    </div>

    <script>
        function go(type) {
            const sid = document.getElementById('sem_id').value;
            const cid = document.getElementById('class_id').value;
            if (!sid || !cid) {
                alert('Pilih Semester dan Kelas dulu.');
                return;
            }

            // gunakan base URL dari Laravel -> akan jadi http://localhost/erapor/public
            const base = "{{ url('/') }}";

            let path = '';
            if (type === 'attendance') path = `${base}/classes/${cid}/semesters/${sid}/attendance`;
            if (type === 'notes') path = `${base}/classes/${cid}/semesters/${sid}/notes`;
            if (type === 'promotions') path = `${base}/classes/${cid}/semesters/${sid}/promotions`;

            window.location.href = path;
        }
    </script>

@endsection
