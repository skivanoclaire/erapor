@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
    <form method="POST" action="{{ route('users.store') }}" class="bg-white rounded-lg shadow p-4 max-w-3xl" x-data="{
        password: '',
        strength: 0,
        strengthText: '',
        strengthColor: '',
        checkStrength() {
            const pwd = this.password;
            let score = 0;

            if (pwd.length >= 8) score++;
            if (pwd.length >= 12) score++;
            if (/[a-z]/.test(pwd)) score++;
            if (/[A-Z]/.test(pwd)) score++;
            if (/[0-9]/.test(pwd)) score++;
            if (/[^a-zA-Z0-9]/.test(pwd)) score++;

            this.strength = score;

            if (score === 0) {
                this.strengthText = '';
                this.strengthColor = '';
            } else if (score <= 2) {
                this.strengthText = 'Lemah';
                this.strengthColor = 'text-red-600';
            } else if (score <= 4) {
                this.strengthText = 'Sedang';
                this.strengthColor = 'text-yellow-600';
            } else {
                this.strengthText = 'Kuat';
                this.strengthColor = 'text-green-600';
            }
        },
        isValid() {
            return this.strength >= 4;
        }
    }">
        @csrf
        <h2 class="font-semibold mb-4">Tambah User</h2>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid sm:grid-cols-2 gap-4">
            <label class="text-sm">Sekolah
                <select name="school_id" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach ($schools as $id => $n)
                        <option value="{{ $id }}">{{ $n }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Username
                <input name="username" class="mt-1 w-full border rounded px-3 py-2" required>
            </label>
            <div class="sm:col-span-2">
                <label class="text-sm">Password
                    <input
                        name="password"
                        type="password"
                        class="mt-1 w-full border rounded px-3 py-2"
                        x-model="password"
                        @input="checkStrength()"
                        required
                    >
                </label>
                <div class="mt-2 text-xs" x-show="password.length > 0">
                    <div class="flex items-center gap-2">
                        <span class="font-medium">Kekuatan Password:</span>
                        <span :class="strengthColor" class="font-semibold" x-text="strengthText"></span>
                    </div>
                    <div class="mt-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div
                            class="h-full transition-all duration-300"
                            :class="{
                                'bg-red-500': strength <= 2,
                                'bg-yellow-500': strength > 2 && strength <= 4,
                                'bg-green-500': strength > 4
                            }"
                            :style="`width: ${(strength / 6) * 100}%`"
                        ></div>
                    </div>
                    <div class="mt-2 text-gray-600">
                        <p class="font-medium">Password harus memenuhi:</p>
                        <ul class="list-disc pl-5 mt-1 space-y-1">
                            <li :class="password.length >= 8 ? 'text-green-600' : 'text-gray-500'">Minimal 8 karakter</li>
                            <li :class="/[a-z]/.test(password) && /[A-Z]/.test(password) ? 'text-green-600' : 'text-gray-500'">Huruf besar dan kecil</li>
                            <li :class="/[0-9]/.test(password) ? 'text-green-600' : 'text-gray-500'">Angka</li>
                            <li :class="/[^a-zA-Z0-9]/.test(password) ? 'text-green-600' : 'text-gray-500'">Simbol (!@#$%^&* dll)</li>
                        </ul>
                    </div>
                </div>
            </div>
            <label class="text-sm">Nama
                <input name="nama" class="mt-1 w-full border rounded px-3 py-2">
            </label>
            <label class="text-sm">Jenis PTK
                <select name="jenis_ptk" class="mt-1 w-full border rounded px-3 py-2">
                    @foreach (['guru', 'guru_mapel', 'kepala_sekolah', 'operator', 'pembina', 'pembimbing_pkl'] as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                    @endforeach
                </select>
            </label>
            <label class="text-sm">Aktif?
                <input type="checkbox" name="ptk_aktif" value="1" class="mt-2" checked>
            </label>
            <label class="text-sm">NIP <input name="nip" class="mt-1 w-full border rounded px-3 py-2"></label>
            <label class="text-sm">NIK <input name="nik" class="mt-1 w-full border rounded px-3 py-2"></label>
            <label class="text-sm">Gelar Depan <input name="gelar_depan"
                    class="mt-1 w-full border rounded px-3 py-2"></label>
            <label class="text-sm">Gelar Belakang <input name="gelar_belakang"
                    class="mt-1 w-full border rounded px-3 py-2"></label>
        </div>
        <div class="mt-4 flex gap-2">
            <button
                type="submit"
                class="rounded px-4 py-2 transition"
                :class="password.length > 0 && !isValid() ? 'bg-gray-400 text-gray-700 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700'"
                :disabled="password.length > 0 && !isValid()"
            >
                Simpan
            </button>
            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection
