@extends('layouts.app')
@section('title', 'Penilaian Angka')

@section('content')
    <div x-data="penilaianBoard()" x-init="$nextTick(() => init())" class="bg-white rounded-lg shadow p-4 overflow-x-auto">
        {{-- Header info --}}
        <div class="mb-3 text-sm text-slate-600">
            <div>
                Kelas: <b>{{ $cs->class->nama_kelas ?? '-' }}</b> •
                Semester: <b>{{ $cs->semester->tahun_ajaran ?? '' }}
                    {{ $cs->semester ? '(' . $cs->semester->semester . ')' : '' }}</b> •
                Mapel: <b>{{ $cs->subject->name ?? '-' }}</b> •
                Guru: <b>{{ $cs->teacher->nama ?? '-' }}</b>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center gap-2 mb-3">
            <button @click="showCreate=true" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Buat Penilaian</button>

            <form method="POST" action="{{ route('assessments.recompute', $cs) }}">
                @csrf
                <button class="px-3 py-2 rounded bg-amber-600 text-white text-sm">Rekap Ulang</button>
            </form>

            <a href="{{ route('class-subjects.final-grades.edit', $cs) }}" class="px-3 py-2 border rounded text-sm">Input
                Nilai Akhir</a>
        </div>

        {{-- Alerts --}}
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

        {{-- Hidden standalone delete forms (hindari nested form) --}}
        @foreach ($assessments as $ax)
            <form id="del_asmt_{{ $ax->id }}" method="POST" action="{{ route('assessments.destroy', $ax) }}"
                class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        {{-- Form grid skor --}}
        <form id="scoresForm" method="POST" action="{{ route('assessments.scores.save', $cs) }}">
            @csrf
            <table class="min-w-full text-sm">
                {{-- Header 1 --}}
                <thead>
                    <tr class="text-left text-white">
                        <th rowspan="2" class="bg-slate-600 px-2 py-2 w-10">No</th>
                        <th rowspan="2" class="bg-slate-600 px-2 py-2 w-64">Nama Peserta Didik</th>

                        @php
                            $colF = $groups['formatif']->count();
                            $colS = $groups['sumatif']->count();
                            $colAS = $groups['sumatif_as']->count();
                        @endphp

                        @if ($colF > 0)
                            <th colspan="{{ $colF + 1 }}" class="bg-orange-600 px-2 py-2 text-center">FORMATIF (F)</th>
                        @endif
                        @if ($colS > 0)
                            <th colspan="{{ $colS + 1 }}" class="bg-orange-600 px-2 py-2 text-center">SUMATIF (S)</th>
                        @endif
                        @if ($colAS > 0)
                            <th colspan="{{ $colAS + 1 }}" class="bg-orange-600 px-2 py-2 text-center">SUMATIF AS (AS)
                            </th>
                        @endif

                        <th rowspan="2" class="bg-cyan-700 px-2 py-2 text-center text-white">AKHIR</th>
                    </tr>

                    {{-- Header 2 --}}
                    <tr class="text-slate-700">
                        @foreach (['formatif' => 'F', 'sumatif' => 'S', 'sumatif_as' => 'AS'] as $t => $code)
                            @foreach ($groups[$t] as $i => $a)
                                @php $label = sprintf('%s %02d', $code, $loop->iteration); @endphp
                                <th class="bg-orange-50 px-2 py-1 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        <span class="font-medium">{{ $label }}</span>
                                        <button type="submit" form="del_asmt_{{ $a->id }}"
                                            class="px-1 rounded bg-rose-600 text-white"
                                            onclick="return confirm('Hapus penilaian ini?')">×</button>
                                    </div>
                                    <div class="text-[11px] text-slate-500">
                                        Bobot: {{ rtrim(rtrim(number_format($a->weight, 2), '0'), '.') }},
                                        Max: {{ rtrim(rtrim(number_format($a->max_score, 2), '0'), '.') }}
                                    </div>
                                </th>
                            @endforeach
                            @if ($groups[$t]->count() > 0)
                                <th class="bg-orange-100 px-2 py-1 text-center">NA ({{ strtoupper($code) }})</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody>
                    @foreach ($students as $i => $s)
                        <tr class="border-t">
                            <td class="px-2 py-2">{{ $i + 1 }}</td>
                            <td class="px-2 py-2">{{ $s->nama }}</td>

                            {{-- kolom penilaian --}}
                            @foreach (['formatif', 'sumatif', 'sumatif_as'] as $t)
                                @foreach ($groups[$t] as $a)
                                    @php $val = $scores[$a->id][$s->id] ?? null; @endphp
                                    <td class="px-1 py-1">
                                        <input type="number" step="0.01" min="0" max="{{ $a->max_score }}"
                                            name="scores[{{ $a->id }}][{{ $s->id }}]"
                                            value="{{ old('scores.' . $a->id . '.' . $s->id, $val) }}"
                                            class="w-16 border rounded px-2 py-1 text-right"
                                            x-on:input.debounce.200ms="calcRow({{ $s->id }})" x-data
                                            x-init="$el.dataset.max = '{{ $a->max_score }}';
                                            $el.dataset.weight = '{{ $a->weight }}';
                                            $el.dataset.type = '{{ $t }}';">
                                    </td>
                                @endforeach
                                @if ($groups[$t]->count() > 0)
                                    <td class="px-2 py-1 text-center bg-orange-50">
                                        {{-- ID STATIS (bukan :id) --}}
                                        <span id="na_{{ $t }}_{{ $s->id }}">-</span>
                                    </td>
                                @endif
                            @endforeach

                            {{-- AKHIR --}}
                            <td class="px-2 py-1 text-center bg-cyan-50 font-semibold">
                                {{-- ID STATIS (bukan :id) --}}
                                <span id="final_{{ $s->id }}">-</span>
                            </td>
                        </tr>
                    @endforeach

                    @if ($students->isEmpty())
                        <tr>
                            <td colspan="999" class="py-6 text-center text-slate-500">Belum ada siswa.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                <button class="px-4 py-2 rounded bg-blue-600 text-white">Simpan Data</button>
            </div>
        </form>

        {{-- Modal: Buat Penilaian --}}
        <div x-show="showCreate" x-cloak class="fixed inset-0 grid place-items-center bg-black/40">
            <div class="bg-white w-[680px] max-w-full rounded shadow p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Buat Penilaian</h3>
                    <button class="px-2 rounded bg-slate-200" @click="showCreate=false">×</button>
                </div>

                <form method="POST" action="{{ route('assessments.store', $cs) }}">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-3">
                        <label class="text-sm">Tipe Penilaian
                            <select name="type" class="mt-1 w-full border rounded px-3 py-2">
                                <option value="formatif">Formatif (F)</option>
                                <option value="sumatif">Sumatif (S)</option>
                                <option value="sumatif_as">Sumatif AS (AS)</option>
                            </select>
                        </label>

                        <label class="text-sm">Teknik Penilaian
                            <select name="technique_id" class="mt-1 w-full border rounded px-3 py-2">
                                <option value="">—</option>
                                @foreach ($techniques as $t)
                                    <option value="{{ $t->id }}">{{ $t->short_name }} — {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="text-sm sm:col-span-2">Judul / Deskripsi singkat
                            <input name="title" class="mt-1 w-full border rounded px-3 py-2" required>
                        </label>

                        <label class="text-sm">Tanggal
                            <input type="date" name="date" class="mt-1 w-full border rounded px-3 py-2">
                        </label>

                        <label class="text-sm">Bobot Penilaian
                            <input type="number" name="weight" step="0.01" min="0.01" value="1"
                                class="mt-1 w-full border rounded px-3 py-2">
                        </label>

                        <label class="text-sm">Skor Maksimum
                            <input type="number" name="max_score" step="0.01" min="1" value="100"
                                class="mt-1 w-full border rounded px-3 py-2">
                        </label>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button class="px-3 py-2 rounded bg-blue-600 text-white">Simpan</button>
                        <button type="button" class="px-3 py-2 border rounded" @click="showCreate=false">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine helpers --}}
    <script>
        function penilaianBoard() {
            // parser angka yang support koma
            const toNum = (v) => {
                if (typeof v === 'string') v = v.replace(',', '.');
                const n = parseFloat(v);
                return Number.isFinite(n) ? n : NaN;
            };

            return {
                showCreate: false,
                init() {
                    // hitung semua baris saat elemen sudah ter-render
                    @foreach ($students as $s)
                        this.calcRow({{ $s->id }});
                    @endforeach
                },
                calcRow(studentId) {
                    // Ambil semua input untuk siswa ini
                    const inputs = document.querySelectorAll(`input[name^="scores["][name$="[${studentId}]"]`);
                    let byType = {
                        formatif: {
                            num: 0,
                            den: 0
                        },
                        sumatif: {
                            num: 0,
                            den: 0
                        },
                        sumatif_as: {
                            num: 0,
                            den: 0
                        }
                    };

                    inputs.forEach(el => {
                        const raw = toNum(el.value);
                        if (Number.isNaN(raw)) return;
                        const max = toNum(el.dataset.max || '100') || 100;
                        const w = toNum(el.dataset.weight || '1') || 1;
                        const t = el.dataset.type;
                        byType[t].num += (raw / (max || 1) * 100.0) * w;
                        byType[t].den += w;
                    });

                    const fmt = (x) => Number.isFinite(x) ? x.toFixed(2) : '-';
                    const naF = byType.formatif.den ? byType.formatif.num / byType.formatif.den : null;
                    const naS = byType.sumatif.den ? byType.sumatif.num / byType.sumatif.den : null;
                    const naAS = byType.sumatif_as.den ? byType.sumatif_as.num / byType.sumatif_as.den : null;

                    const elF = document.getElementById(`na_formatif_${studentId}`);
                    const elS = document.getElementById(`na_sumatif_${studentId}`);
                    const elAS = document.getElementById(`na_sumatif_as_${studentId}`);
                    if (elF) elF.textContent = naF != null ? fmt(naF) : '-';
                    if (elS) elS.textContent = naS != null ? fmt(naS) : '-';
                    if (elAS) elAS.textContent = naAS != null ? fmt(naAS) : '-';

                    const totalNum = [byType.formatif.num, byType.sumatif.num, byType.sumatif_as.num].reduce((a, b) => a +
                        b, 0);
                    const totalDen = [byType.formatif.den, byType.sumatif.den, byType.sumatif_as.den].reduce((a, b) => a +
                        b, 0);
                    const final = totalDen ? (totalNum / totalDen) : null;

                    const elFinal = document.getElementById(`final_${studentId}`);
                    if (elFinal) elFinal.textContent = final != null ? fmt(final) : '-';
                }
            }
        }
    </script>
@endsection
