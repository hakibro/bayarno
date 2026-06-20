<tbody class="bg-white divide-y divide-gray-100">
    @forelse($siswa as $s)
        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $s->nama }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $s->idperson }}</td>
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
                        <button type="submit" class="text-green-600 hover:text-green-800 font-medium text-sm">
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
