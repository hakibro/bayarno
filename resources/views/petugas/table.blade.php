<tbody class="bg-white divide-y divide-gray-100">
    @forelse($siswa as $s)
        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $s->nama }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $s->idperson }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->no_hp_aktif }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->unit_formal }} / {{ $s->kelas_formal }}
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
                    <form method="POST" action="{{ route('petugas.restore', $s->id) }}" class="inline ml-2"
                        onsubmit="showLoading()">
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
