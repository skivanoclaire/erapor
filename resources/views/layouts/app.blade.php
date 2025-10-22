<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'E-Rapor')</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="font-semibold tracking-wide">E-Rapor</a>
            @php
                $user = auth()->user();
                $isAdmin = in_array($user->jenis_ptk, ['kepala_sekolah', 'operator']);

                // Deteksi menu aktif untuk highlighting
                $isPenilaian = request()->routeIs('assessment-techniques.*') || request()->routeIs('monitor-penilaian.*') || request()->routeIs('legger.*');
                $isPKL = request()->routeIs('pkl-groups.*') || request()->routeIs('pkl-objectives.*');
                $isPengaturan = request()->routeIs('media.*') || request()->routeIs('rdate.*') || request()->routeIs('reports.*');
            @endphp

            <div class="flex gap-4 text-sm items-center">

                @if($isAdmin)
                    <a class="hover:text-blue-600" href="{{ route('schools.show', 1) }}">Sekolah</a>
                    <a class="hover:text-blue-600" href="{{ route('semesters.index') }}">Semester</a>
                    <a class="hover:text-blue-600" href="{{ route('users.index') }}">Users</a>
                    <a class="hover:text-blue-600" href="{{ route('classes.index') }}">Kelas</a>
                    <a class="hover:text-blue-600" href="{{ route('students.index') }}">Siswa</a>
                    <a class="hover:text-blue-600" href="{{ route('subjects.index') }}">Mapel</a>
                @endif

                <a class="hover:text-blue-600" href="{{ route('class-subjects.index') }}">Mapel Kelas</a>

                {{-- Dropdown Penilaian (Tailwind + Alpine) --}}
                <div x-data="{ open: false }" class="relative" @keydown.escape="open=false">
                    <button type="button" @click="open=!open" @click.outside="open=false"
                        class="hover:text-blue-600 inline-flex items-center gap-1">
                        <span class="{{ $isPenilaian ? 'text-blue-600 font-semibold' : '' }}">Penilaian</span>
                        <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-cloak x-show="open" x-transition.origin.top.left
                        class="absolute left-0 mt-2 w-48 rounded-md border border-slate-200 bg-white shadow-lg z-20 py-1">
                        @if($isAdmin)
                            <a href="{{ route('assessment-techniques.index') }}"
                                class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('assessment-techniques.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Teknik Nilai
                            </a>
                        @endif
                        <a href="{{ route('monitor-penilaian.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('monitor-penilaian.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Monitor Penilaian
                        </a>
                        <a href="{{ route('legger.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('legger.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Daftar Legger
                        </a>
                    </div>
                </div>

                <a class="hover:text-blue-600" href="{{ route('class-tools.index') }}">Aksi Kelas</a>
                <a class="hover:text-blue-600" href="{{ route('p5-projects.index') }}">P5BK</a>
                <a class="hover:text-blue-600" href="{{ route('extracurriculars.index') }}">Ekskul</a>

                {{-- Dropdown PKL (Tailwind + Alpine) --}}
                <div x-data="{ open: false }" class="relative" @keydown.escape="open=false">
                    <button type="button" @click="open=!open" @click.outside="open=false"
                        class="hover:text-blue-600 inline-flex items-center gap-1">
                        <span class="{{ $isPKL ? 'text-blue-600 font-semibold' : '' }}">PKL</span>
                        <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-cloak x-show="open" x-transition.origin.top.left
                        class="absolute left-0 mt-2 w-48 rounded-md border border-slate-200 bg-white shadow-lg z-20 py-1">
                        <a href="{{ route('pkl-groups.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('pkl-groups.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Kelompok PKL
                        </a>
                        <a href="{{ route('pkl-objectives.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('pkl-objectives.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Tujuan PKL
                        </a>
                    </div>
                </div>

                <a class="hover:text-blue-600" href="{{ route('cocurriculars.index') }}">Kokurikuler</a>

                {{-- Dropdown Rapor Setting (Tailwind + Alpine) --}}
                <div x-data="{ open: false }" class="relative" @keydown.escape="open=false">
                    <button type="button" @click="open=!open" @click.outside="open=false"
                        class="hover:text-blue-600 inline-flex items-center gap-1">
                        <span class="{{ $isPengaturan ? 'text-blue-600 font-semibold' : '' }}">Pengaturan</span>
                        <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-cloak x-show="open" x-transition.origin.top.left
                        class="absolute left-0 mt-2 w-48 rounded-md border border-slate-200 bg-white shadow-lg z-20 py-1">
                        @if($isAdmin)
                            <a href="{{ route('media.index') }}"
                                class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('media.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Media
                            </a>
                            <a href="{{ route('rdate.index') }}"
                                class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('rdate.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Tanggal Rapor
                            </a>
                        @endif
                        <a href="{{ route('reports.class-board') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('reports.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Cetak Rapor
                        </a>
                    </div>
                </div>

                {{-- User Info & Logout --}}
                @auth
                <div class="border-l border-slate-200 pl-4 ml-4 flex items-center gap-3">
                    <span class="text-xs text-slate-600">
                        <strong>{{ auth()->user()->nama }}</strong>
                        <span class="block text-[10px]">({{ ucwords(str_replace('_', ' ', auth()->user()->jenis_ptk)) }})</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs px-3 py-1.5 rounded bg-red-500 text-white hover:bg-red-600 transition">
                            Keluar
                        </button>
                    </form>
                </div>
                @endauth

            </div>


        </div>
    </nav>

    <main class="container mx-auto px-4 py-6">
        @if (session('ok'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 text-green-800 px-4 py-3">
                {{ session('ok') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }}
        <a href="https://github.com/skivanoclaire" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">
            PT Benuanta Technology Consultant - Bayu Adi H
        </a>
        <span class="mx-1">|</span>
        <a href="https://www.linkedin.com/in/noclaire/" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">
            LinkedIn
        </a>
        <span class="mx-1">|</span>
        <a href="https://github.com/skivanoclaire" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">
            GitHub
        </a>
    </footer>
</body>

</html>
