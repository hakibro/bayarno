@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-6">Daftar
            Siswa</h1>

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

        <!-- Search Box -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-4 mb-4 border border-gray-100">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="🔍 Cari nama atau ID siswa..."
                    class="w-full px-5 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-gray-700"
                    value="{{ request('search') }}">
                <svg class="absolute left-4 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Filter Dropdowns -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-6 border border-gray-100">
            <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="hidden" name="search" id="searchField" value="{{ request('search') }}">
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Unit Formal</label>
                    <select name="unit_formal"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">-- Semua Unit --</option>
                        @foreach ($unitOptions as $option)
                            <option value="{{ $option }}" {{ request('unit_formal') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Kelas Formal</label>
                    <select name="kelas_formal"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($kelasOptions as $option)
                            <option value="{{ $option }}" {{ request('kelas_formal') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Asrama Pondok</label>
                    <select name="asrama_pondok"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">-- Semua Asrama --</option>
                        @foreach ($asramaOptions as $option)
                            <option value="{{ $option }}"
                                {{ request('asrama_pondok') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Kamar Pondok</label>
                    <select name="kamar_pondok"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">-- Semua Kamar --</option>
                        @foreach ($kamarOptions as $option)
                            <option value="{{ $option }}"
                                {{ request('kamar_pondok') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Tingkat Diniyah</label>
                    <select name="tingkat_diniyah"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">-- Semua Tingkat --</option>
                        @foreach ($tingkatOptions as $option)
                            <option value="{{ $option }}"
                                {{ request('tingkat_diniyah') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Kelas Diniyah</label>
                    <select name="kelas_diniyah"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($kelasDiniyahOptions as $option)
                            <option value="{{ $option }}"
                                {{ request('kelas_diniyah') == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                        Filter
                    </button>
                    <a href="{{ route('petugas.dashboard') }}"
                        class="ml-2 bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium inline-block">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID
                            Person</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No HP
                            Aktif</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Unit/Kelas</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Toggle</th>
                    </tr>
                </thead>
                <tbody id="siswaTableBody" class="bg-white divide-y divide-gray-100">
                    @forelse($siswa as $s)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $s->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->idperson }}</td>
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
                                            class="text-green-600 hover:text-green-800 font-medium text-sm">
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="paginationContainer" class="mt-4">
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
                // Small delay to let cascading dropdowns update first
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
                    document.getElementById('siswaTableBody').innerHTML = data.html;
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
