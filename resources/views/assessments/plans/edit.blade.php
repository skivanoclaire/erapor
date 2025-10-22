@extends('layouts.app')
@section('title', 'Rencana Penilaian')

@section('content')
    <form method="POST" action="{{ route('assessment-plans.update', $cs) }}" class="bg-white rounded-lg shadow p-4 max-w-2xl">
        @csrf
        @method('PUT')

        <h2 class="font-semibold mb-3">
            Rencana Penilaian — {{ $cs->class->nama_kelas ?? '-' }} / {{ $cs->subject->short_name ?? '-' }}
        </h2>

        @if ($errors->any())
            <div class="mb-3 rounded border border-rose-200 bg-rose-50 text-rose-800 px-3 py-2 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-sm block">Rencana Formatif (F)
                    <input type="number" name="planned_formatif" min="0"
                        value="{{ old('planned_formatif', $plan->planned_formatif) }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </label>
                <label class="text-sm block mt-3">Bobot Blok F
                    <input type="number" step="0.01" min="0" name="weight_formatif"
                        value="{{ old('weight_formatif', $plan->weight_formatif) }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </label>
            </div>

            <div>
                <label class="text-sm block">Rencana Sumatif (S)
                    <input type="number" name="planned_sumatif" min="0"
                        value="{{ old('planned_sumatif', $plan->planned_sumatif) }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </label>
                <label class="text-sm block mt-3">Bobot Blok S
                    <input type="number" step="0.01" min="0" name="weight_sumatif"
                        value="{{ old('weight_sumatif', $plan->weight_sumatif) }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </label>
            </div>

            <div>
                <label class="text-sm block">Rencana Sumatif AS (AS)
                    <input type="number" name="planned_sumatif_as" min="0"
                        value="{{ old('planned_sumatif_as', $plan->planned_sumatif_as) }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </label>
                <label class="text-sm block mt-3">Bobot Blok AS
                    <input type="number" step="0.01" min="0" name="weight_sumatif_as"
                        value="{{ old('weight_sumatif_as', $plan->weight_sumatif_as) }}"
                        class="mt-1 w-full border rounded px-3 py-2">
                </label>
            </div>
        </div>

        <div class="mt-4 flex gap-2">
            <button class="px-3 py-2 rounded bg-blue-600 text-white">Simpan</button>
            <a href="{{ url()->previous() }}" class="px-3 py-2 border rounded">Batal</a>
        </div>
    </form>
@endsection
