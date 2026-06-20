@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            📊 Riwayat Toggle No. HP (Semua Petugas)
        </h1>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- Filter Form -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-6 border border-gray-100">
            <form method="GET" action="{{ route('admin.history') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Petugas</label>
                    <select name="petugas_id"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Petugas</option>
                        @foreach ($petugasList as $p)
                            <option value="{{ $p->id }}" {{ request('petugas_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Sudah Dikembalikan
                        </option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-xl hover:shadow-lg transition-all duration-300 font-medium mr-2">
                        Filter
                    </button>
                    <a href="{{ route('admin.history') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-300 font-medium inline-block">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">No. HP Temporary</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kembali Pada</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($history as $item)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $item->petugas->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium">{{ $item->siswa->nama }}</div>
                                <div class="text-gray-500">{{ $item->siswa->kelas_formal }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $item->no_hp_temporary }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1.5 text-xs font-semibold rounded-xl shadow-sm
                            {{ $item->action == 'activate' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                                    {{ $item->action == 'activate' ? '✓ Aktifkan' : '↩ Kembalikan' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->returned_at)
                                    <span
                                        class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                        ✓ Sudah Dikembalikan
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-yellow-100 text-yellow-700 border border-yellow-200 shadow-sm">
                                        ⏱ Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($item->returned_at)
                                    {{ $item->returned_at->format('d/m/Y H:i') }}
                                @else
                                    {{ $item->scheduled_return_at->format('d/m/Y H:i') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-400 text-lg">
                                    <span class="text-4xl mb-2 block">📋</span>
                                    <p class="font-medium">Belum ada riwayat toggle</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $history->links() }}
        </div>
    </div>
@endsection
