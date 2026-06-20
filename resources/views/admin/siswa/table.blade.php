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
            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->unit_formal }} / {{ $s->kelas_formal }}</td>
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
                    class="text-green-600 hover:text-green-800 font-medium mr-3 transition-colors">Ubah Nomor</button>
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
