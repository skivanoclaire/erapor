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
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="font-semibold tracking-wide">E-Rapor</a>
            @php
                $isPKL = request()->routeIs('pkl-groups.*') || request()->routeIs('pkl-objectives.*');
            @endphp

            <div class="flex gap-4 text-sm items-center">
                <a class="hover:text-blue-600" href="{{ route('schools.show', 1) }}">Sekolah</a>
                <a class="hover:text-blue-600" href="{{ route('semesters.index') }}">Semester</a>
                <a class="hover:text-blue-600" href="{{ route('users.index') }}">Users</a>
                <a class="hover:text-blue-600" href="{{ route('classes.index') }}">Kelas</a>
                <a class="hover:text-blue-600" href="{{ route('students.index') }}">Siswa</a>
                <a class="hover:text-blue-600" href="{{ route('subjects.index') }}">Mapel</a>
                <a class="hover:text-blue-600" href="{{ route('class-subjects.index') }}">Mapel Kelas</a>




                {{-- Dropdown Penilaian (Tailwind + Alpine) --}}
                <div x-data="{ open: false }" class="relative" @keydown.escape="open=false">
                    <button type="button" @click="open=!open" @click.outside="open=false"
                        class="hover:text-blue-600 inline-flex items-center gap-1">
                        <span class="{{ $isPKL ? 'text-blue-600 font-semibold' : '' }}">Penilaian</span>
                        <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-cloak x-show="open" x-transition.origin.top.left
                        class="absolute left-0 mt-2 w-48 rounded-md border border-slate-200 bg-white shadow-lg z-20 py-1">
                        <a href="{{ route('assessment-techniques.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('assessment-techniques.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Teknik Nilai
                        </a>
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
                        <span class="{{ $isPKL ? 'text-blue-600 font-semibold' : '' }}">Pengaturan</span>
                        <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-cloak x-show="open" x-transition.origin.top.left
                        class="absolute left-0 mt-2 w-48 rounded-md border border-slate-200 bg-white shadow-lg z-20 py-1">
                        <a href="{{ route('media.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('media.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Media
                        </a>
                        <a href="{{ route('report-settings.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('report-settings.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Pengaturan Rapor
                        </a>
                        <a href="{{ route('rws.index') }}"
                            class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('rws.*') ? 'text-blue-600 font-semibold' : '' }}">
                            Tanda Tangan
                            <a href="{{ route('rc.index') }}"
                                class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('rc.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Kustom Font
                            </a>
                            <a href="{{ route('rdate.index') }}"
                                class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('rdate.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Tanggal Rapor
                            </a>


                            <a href="{{ route('reports.class-board') }}"
                                class="block px-3 py-2 hover:bg-slate-50 {{ request()->routeIs('reports.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Cetak Rapor
                            </a>


                        </a>
                    </div>
                </div>

            </div>


        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @if (session('ok'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 text-green-800 px-4 py-3">
                {{ session('ok') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} E-Rapor — built with Tailwind & Alpine.
    </footer>
</body>

</html>
