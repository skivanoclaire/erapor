<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Rapor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Card Login -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                <h1 class="text-2xl font-bold text-center">E-Rapor</h1>
                <p class="text-center text-blue-100 text-sm mt-1">SMK Muhammadiyah Plus Tanjung Selor</p>
            </div>

            <!-- Form -->
            <div class="px-8 py-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- Username -->
                    <div class="mb-5">
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="Masukkan username"
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="Masukkan password"
                        >
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition duration-200 shadow-lg hover:shadow-xl"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-center text-xs text-gray-500">
                        Sistem Manajemen Rapor Digital<br>
                        © {{ date('Y') }}
                        <a href="https://github.com/skivanoclaire" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">
                            PT Benuanta Technology Consultant - Bayu Adi H
                        </a>
                        <br>
                        <a href="https://www.linkedin.com/in/noclaire/" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">LinkedIn</a>
                        <span class="mx-1">|</span>
                        <a href="https://github.com/skivanoclaire" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600">GitHub</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Petunjuk Login -->
        <div class="mt-4 bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600 mb-2"><strong>Petunjuk Login:</strong></p>
            <ul class="text-xs text-gray-600 space-y-1">
                <li>• Gunakan username dan password yang telah diberikan</li>
                <li>• Hubungi operator sekolah jika lupa password</li>
            </ul>
        </div>
    </div>
</body>
</html>
