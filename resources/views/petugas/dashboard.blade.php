@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <h1
                class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                Daftar Siswa
            </h1>
            <p class="text-gray-600 text-sm sm:text-base">Kelola data siswa dengan mudah dan cepat</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div
                class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-xl mb-4 sm:mb-6 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-700 px-4 sm:px-6 py-3 sm:py-4 rounded-xl mb-4 sm:mb-6 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Search Box -->
        <div
            class="bg-white rounded-2xl shadow-lg p-3 sm:p-4 mb-4 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="🔍 Cari nama atau ID siswa..."
                    class="w-full px-4 sm:px-5 py-3 pl-10 sm:pl-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base text-gray-700 bg-gray-50 hover:bg-white"
                    value="{{ request('search') }}">
                <svg class="absolute left-3 sm:left-4 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Filter Dropdowns -->
        <div
            class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-4 sm:mb-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <form method="GET" id="filterForm" class="space-y-4">
                <input type="hidden" name="search" id="searchField" value="{{ request('search') }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <div>
                        <label class="text-xs sm:text-sm font-semibold mb-2 text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Unit Formal
                        </label>
                        <select name="unit_formal"
                            class="w-full px-3 sm:px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm bg-gray-50 hover:bg-white">
                            <option value="">-- Semua Unit --</option>
                            @foreach ($unitOptions as $option)
                                <option value="{{ $option }}"
                                    {{ request('unit_formal') == $option ? 'selected' : '' }}>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-semibold mb-2 text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Kelas Formal
                        </label>
                        <select name="kelas_formal"
                            class="w-full px-3 sm:px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm bg-gray-50 hover:bg-white">
                            <option value="">-- Semua Kelas --</option>
                            @foreach ($kelasOptions as $option)
                                <option value="{{ $option }}"
                                    {{ request('kelas_formal') == $option ? 'selected' : '' }}>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-semibold mb-2 text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Asrama Pondok
                        </label>
                        <select name="asrama_pondok"
                            class="w-full px-3 sm:px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm bg-gray-50 hover:bg-white">
                            <option value="">-- Semua Asrama --</option>
                            @foreach ($asramaOptions as $option)
                                <option value="{{ $option }}"
                                    {{ request('asrama_pondok') == $option ? 'selected' : '' }}>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-semibold mb-2 text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            Kamar Pondok
                        </label>
                        <select name="kamar_pondok"
                            class="w-full px-3 sm:px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm bg-gray-50 hover:bg-white">
                            <option value="">-- Semua Kamar --</option>
                            @foreach ($kamarOptions as $option)
                                <option value="{{ $option }}"
                                    {{ request('kamar_pondok') == $option ? 'selected' : '' }}>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-semibold mb-2 text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-orange-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Tingkat Diniyah
                        </label>
                        <select name="tingkat_diniyah"
                            class="w-full px-3 sm:px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm bg-gray-50 hover:bg-white">
                            <option value="">-- Semua Tingkat --</option>
                            @foreach ($tingkatOptions as $option)
                                <option value="{{ $option }}"
                                    {{ request('tingkat_diniyah') == $option ? 'selected' : '' }}>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-semibold mb-2 text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Kelas Diniyah
                        </label>
                        <select name="kelas_diniyah"
                            class="w-full px-3 sm:px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm bg-gray-50 hover:bg-white">
                            <option value="">-- Semua Kelas --</option>
                            @foreach ($kelasDiniyahOptions as $option)
                                <option value="{{ $option }}"
                                    {{ request('kelas_diniyah') == $option ? 'selected' : '' }}>{{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-2">
                    <button type="submit"
                        class="w-full sm:w-auto bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-xl hover:shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium text-sm sm:text-base flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('petugas.dashboard') }}"
                        class="w-full sm:w-auto bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-200 hover:shadow-md transition-all duration-300 font-medium text-sm sm:text-base flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Mobile Card View -->
        <div id="siswaCardBody" class="md:hidden space-y-3 mb-4">
            @forelse($siswa as $s)
                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-4 py-3">
                        <h3 class="text-white font-bold text-base truncate">{{ $s->nama }}</h3>
                        <p class="text-blue-50 text-xs">ID: {{ $s->idperson }}</p>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 font-medium">No HP Aktif</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $s->no_hp_aktif }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 font-medium">Unit / Kelas</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $s->unit_formal }} /
                                    {{ $s->kelas_formal }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-xs font-semibold text-gray-700">Status Toggle</span>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('petugas.toggle', $s->id) }}" class="inline"
                                    onsubmit="showLoading()">
                                    @csrf
                                    <label class="toggle-switch"
                                        title="{{ !$s->no_hp_asli ? 'Siswa tidak memiliki nomor HP asli' : '' }}">
                                        <input type="checkbox" {{ $s->is_toggled ? 'checked' : '' }}
                                            {{ !$s->no_hp_asli ? 'disabled' : '' }} onchange="this.form.submit()">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </form>
                                @if ($s->is_toggled)
                                    <form method="POST" action="{{ route('petugas.restore', $s->id) }}" class="inline"
                                        onsubmit="showLoading()">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-lg hover:bg-green-200 font-medium text-xs transition-colors">
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-500 text-sm">Tidak ada data siswa</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div
            class="hidden md:block bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID
                            Person</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No HP
                            Aktif</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Unit/Kelas</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Toggle</th>
                    </tr>
                </thead>
                <tbody id="siswaTableBody" class="bg-white divide-y divide-gray-100">
                    @forelse($siswa as $s)
                        <tr
                            class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $s->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $s->idperson }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->no_hp_aktif }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->unit_formal }} /
                                {{ $s->kelas_formal }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <form method="POST" action="{{ route('petugas.toggle', $s->id) }}" class="inline"
                                    onsubmit="showLoading()">
                                    @csrf
                                    <label class="toggle-switch"
                                        title="{{ !$s->no_hp_asli ? 'Siswa tidak memiliki nomor HP asli' : '' }}">
                                        <input type="checkbox" {{ $s->is_toggled ? 'checked' : '' }}
                                            {{ !$s->no_hp_asli ? 'disabled' : '' }} onchange="this.form.submit()">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </form>
                                @if ($s->is_toggled)
                                    <form method="POST" action="{{ route('petugas.restore', $s->id) }}"
                                        class="inline ml-2" onsubmit="showLoading()">
                                        @csrf
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-800 font-medium text-sm hover:underline transition-all">
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="paginationContainer" class="mt-4 sm:mt-6">
            {{ $siswa->links() }}
        </div>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('active');
        }

        // AJAX Search with Debounce
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const searchField = document.getElementById('searchField');
        const filterForm = document.getElementById('filterForm');

        // Prevent form submission and use AJAX instead
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch();
        });

        // Trigger search when dropdowns change
        const allSelects = filterForm.querySelectorAll('select');
        allSelects.forEach(select => {
            select.addEventListener('change', function() {
                setTimeout(() => {
                    performSearch();
                }, 100);
            });
        });

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });

        function performSearch() {
            const formData = new FormData(filterForm);
            formData.set('search', searchInput.value);

            fetch('{{ route('petugas.dashboard') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Update both table body and card body
                    const tableBody = document.getElementById('siswaTableBody');
                    const cardBody = document.getElementById('siswaCardBody');

                    if (tableBody && data.html) {
                        tableBody.innerHTML = data.html;
                    }
                    if (cardBody && data.cards) {
                        cardBody.innerHTML = data.cards;
                    }

                    document.getElementById('paginationContainer').innerHTML = data.pagination;
                    searchField.value = searchInput.value;
                })
                .catch(error => console.error('Error:', error));
        }

        // Cascading Dropdown: Unit Formal -> Kelas Formal
        const unitSelect = document.querySelector('select[name="unit_formal"]');
        const kelasSelect = document.querySelector('select[name="kelas_formal"]');
        const selectedKelas = "{{ request('kelas_formal') }}";

        unitSelect.addEventListener('change', function() {
            const unit = this.value;
            kelasSelect.innerHTML = '<option value="">-- Semua Kelas --</option>';
            kelasSelect.value = ''; // Clear selection

            if (unit) {
                fetch(`{{ route('petugas.getKelasByUnit') }}?unit=${encodeURIComponent(unit)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas;
                            option.textContent = kelas;
                            kelasSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Cascading Dropdown: Asrama Pondok -> Kamar Pondok
        const asramaSelect = document.querySelector('select[name="asrama_pondok"]');
        const kamarSelect = document.querySelector('select[name="kamar_pondok"]');

        asramaSelect.addEventListener('change', function() {
            const asrama = this.value;
            kamarSelect.innerHTML = '<option value="">-- Semua Kamar --</option>';
            kamarSelect.value = ''; // Clear selection

            if (asrama) {
                fetch(`{{ route('petugas.getKamarByAsrama') }}?asrama=${encodeURIComponent(asrama)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kamar => {
                            const option = document.createElement('option');
                            option.value = kamar;
                            option.textContent = kamar;
                            kamarSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Cascading Dropdown: Tingkat Diniyah -> Kelas Diniyah
        const tingkatSelect = document.querySelector('select[name="tingkat_diniyah"]');
        const kelasDiniyahSelect = document.querySelector('select[name="kelas_diniyah"]');

        tingkatSelect.addEventListener('change', function() {
            const tingkat = this.value;
            kelasDiniyahSelect.innerHTML = '<option value="">-- Semua Kelas --</option>';
            kelasDiniyahSelect.value = ''; // Clear selection

            if (tingkat) {
                fetch(`{{ route('petugas.getKelasByTingkat') }}?tingkat=${encodeURIComponent(tingkat)}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas;
                            option.textContent = kelas;
                            kelasDiniyahSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
