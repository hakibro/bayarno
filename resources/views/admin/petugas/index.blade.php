@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Data
                Petugas</h1>
            <button onclick="showAddModal()"
                class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                + Tambah Petugas
            </button>
        </div>

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

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. HP
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($petugas as $p)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $p->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $p->no_hp }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $p->user->email }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $p->user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($p->user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    onclick="showEditModal({{ $p->id }}, '{{ $p->nama }}', '{{ $p->no_hp }}', '{{ $p->user->email }}', '{{ $p->user->role }}')"
                                    class="text-blue-600 hover:text-blue-800 font-medium mr-3 transition-colors">
                                    Edit
                                </button>
                                <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data petugas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $petugas->links() }}
        </div>
    </div>

    <!-- Modal Tambah Petugas -->
    <div id="addModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div
            class="relative top-20 mx-auto p-6 border border-gray-200 w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-md">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-gray-800">Tambah Petugas</h3>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form action="{{ route('admin.petugas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" name="nama" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                    <input type="text" name="no_hp" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
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

    <!-- Modal Edit Petugas -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div
            class="relative top-20 mx-auto p-6 border border-gray-200 w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-md">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-gray-800">Edit Petugas</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" id="edit_nama" name="nama" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                    <input type="text" id="edit_no_hp" name="no_hp" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password (kosongkan jika tidak
                        diubah)</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select id="edit_role" name="role" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
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

    <script>
        function showAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function showEditModal(id, nama, no_hp, email, role) {
            document.getElementById('editForm').action = '/admin/petugas/' + id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_no_hp').value = no_hp;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
@endsection
