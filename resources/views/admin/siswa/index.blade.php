@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Data
                Siswa</h1>
            <div class="flex gap-3">
                <form method="POST" action="{{ route('admin.sync.siswa') }}" class="inline" onsubmit="showLoading()">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                        🔄 Sync Manual
                    </button>
                </form>
                <button onclick="showAddModal()"
                    class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                    + Tambah Siswa
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 px-6 py-4 rounded-xl mb-6 shadow-sm">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
                ✖ {{ session('error') }}
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
                                {{ request('asrama_pondok') == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                                {{ request('kamar_pondok') == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                                {{ request('tingkat_diniyah') == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">Filter</button>
                    <a href="{{ route('admin.siswa.index') }}"
                        class="ml-2 bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium inline-block">Reset</a>
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
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pemilik
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Unit/Kelas</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Toggle</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($siswa as $s)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $s->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->idperson }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->no_hp_asli }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if ($s->no_hp_pemilik)
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-lg {{ $s->no_hp_pemilik == 'ayah' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                        {{ ucfirst($s->no_hp_pemilik) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->unit_formal }} / {{ $s->kelas_formal }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <label class="toggle-switch">
                                    <input type="checkbox" {{ $s->is_toggled ? 'checked' : '' }}
                                        onchange="toggleSiswa({{ $s->id }}, this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="showEditModal({{ $s->id }})"
                                    class="text-blue-600 hover:text-blue-800 font-medium mr-3 transition-colors">Edit</button>
                                <button onclick="showPhoneModal({{ $s->id }})"
                                    class="text-green-600 hover:text-green-800 font-medium mr-3 transition-colors">Ubah
                                    Nomor</button>
                                <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')"
                                        class="text-red-600 hover:text-red-800 font-medium transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $siswa->links() }}
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div id="addModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div
            class="relative top-20 mx-auto p-6 border border-gray-200 w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-md">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-gray-800">Tambah Siswa</h3>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Person</label>
                    <input type="text" name="idperson" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" name="nama" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP Asli</label>
                    <input type="text" name="no_hp_asli" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" onclick="closeAddModal()"
                        class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div
            class="relative top-20 mx-auto p-6 border border-gray-200 w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-md">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-gray-800">Edit Siswa</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Person</label>
                    <input type="text" id="edit_idperson" name="idperson" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" id="edit_nama" name="nama" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP Asli</label>
                    <input type="text" id="edit_no_hp_asli" name="no_hp_asli" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ubah Nomor HP -->
    <div id="phoneModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div
            class="relative top-20 mx-auto p-6 border border-gray-200 w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-md">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-gray-800">Ubah Nomor HP</h3>
                <button onclick="closePhoneModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form id="phoneForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP (Format: 08xxx - label)</label>
                    <input type="text" id="phone_no_hp_asli" name="no_hp_asli" required
                        placeholder="085748799794 - ayah"
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="flex justify-end gap-3 mt-5">
                    <button type="button" onclick="closePhoneModal()"
                        class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium">Batal</button>
                    <button type="submit"
                        class="bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('active');
        }

        function toggleSiswa(id, checkbox) {
            showLoading();
            fetch('/admin/siswa/' + id + '/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success - checkbox already updated
                    } else {
                        // Revert checkbox on error
                        checkbox.checked = !checkbox.checked;
                        alert(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    // Revert checkbox on error
                    checkbox.checked = !checkbox.checked;
                    alert('Terjadi kesalahan koneksi');
                })
                .finally(() => {
                    document.getElementById('loadingOverlay').classList.remove('active');
                });
        }

        function showAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function showEditModal(id) {
            fetch('/admin/siswa/' + id + '/edit')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editForm').action = '/admin/siswa/' + id;
                    document.getElementById('edit_idperson').value = data.idperson;
                    document.getElementById('edit_nama').value = data.nama;
                    document.getElementById('edit_no_hp_asli').value = data.no_hp_asli;
                    document.getElementById('editModal').classList.remove('hidden');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function showPhoneModal(id) {
            fetch('/admin/siswa/' + id + '/edit')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('phoneForm').action = '/admin/siswa/' + id + '/update-phone';
                    document.getElementById('phone_no_hp_asli').value = data.no_hp_asli;
                    document.getElementById('phoneModal').classList.remove('hidden');
                });
        }

        function closePhoneModal() {
            document.getElementById('phoneModal').classList.add('hidden');
        }

        // AJAX Search
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('searchField').value = e.target.value;
                performAjaxSearch();
            }, 500);
        });

        function performAjaxSearch() {
            const formData = new FormData(document.getElementById('filterForm'));
            const params = new URLSearchParams(formData);

            showLoading();
            fetch('{{ route('admin.siswa.index') }}?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('tbody').innerHTML = data.html;
                    hideLoading();
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();
                });
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }
    </script>
@endsection
