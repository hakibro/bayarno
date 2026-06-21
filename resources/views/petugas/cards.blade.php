@forelse($siswa as $s)
    <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
        <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-4 py-3">
            <h3 class="text-white font-bold text-base truncate">{{ $s->nama }}</h3>
            <p class="text-blue-50 text-xs">ID: {{ $s->idperson }}</p>
        </div>
        <div class="p-4 space-y-3">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500 font-medium">No HP Aktif</p>
                    <p class="text-sm text-gray-800 font-semibold">{{ $s->no_hp_aktif }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500 font-medium">Unit / Kelas</p>
                    <p class="text-sm text-gray-800 font-semibold">{{ $s->unit_formal }} / {{ $s->kelas_formal }}</p>
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
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <p class="text-gray-500 text-sm">Tidak ada data siswa</p>
    </div>
@endforelse
