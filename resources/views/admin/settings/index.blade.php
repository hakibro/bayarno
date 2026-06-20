@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            ⚙️ Pengaturan Sistem
        </h1>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
                ✗ {{ session('error') }}
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ⏱️ Durasi Kembali Otomatis (Menit)
                    </label>
                    <input type="number" name="return_duration_minutes"
                        value="{{ old('return_duration_minutes', $settings['return_duration_minutes']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        min="1" required>
                    <p class="text-sm text-gray-500 mt-2">
                        Waktu untuk mengembalikan nomor HP ke asli secara otomatis (default: 15 menit)
                    </p>
                    @error('return_duration_minutes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        🔄 Interval Sinkronisasi API (Menit)
                    </label>
                    <input type="number" name="api_sync_interval_minutes"
                        value="{{ old('api_sync_interval_minutes', $settings['api_sync_interval_minutes']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        min="1" required>
                    <p class="text-sm text-gray-500 mt-2">
                        Interval waktu untuk sinkronisasi data siswa dari API (default: 60 menit)
                    </p>
                    @error('api_sync_interval_minutes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        🍪 API Cookie (SWN)
                    </label>
                    <textarea name="api_cookie"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all font-mono text-sm"
                        rows="3" required>{{ old('api_cookie', $settings['api_cookie']) }}</textarea>
                    <p class="text-sm text-gray-500 mt-2">
                        Cookie untuk autentikasi API Sisda
                    </p>
                    @error('api_cookie')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                        💾 Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
