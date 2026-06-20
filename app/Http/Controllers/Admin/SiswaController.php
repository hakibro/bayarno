<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Services\ApiService;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Search by name or ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('idperson', 'like', "%{$search}%");
            });
        }

        if ($request->filled('unit_formal')) {
            $query->where('unit_formal', $request->unit_formal);
        }
        if ($request->filled('kelas_formal')) {
            $query->where('kelas_formal', $request->kelas_formal);
        }
        if ($request->filled('asrama_pondok')) {
            $query->where('asrama_pondok', $request->asrama_pondok);
        }
        if ($request->filled('kamar_pondok')) {
            $query->where('kamar_pondok', $request->kamar_pondok);
        }
        if ($request->filled('tingkat_diniyah')) {
            $query->where('tingkat_diniyah', $request->tingkat_diniyah);
        }
        if ($request->filled('kelas_diniyah')) {
            $query->where('kelas_diniyah', $request->kelas_diniyah);
        }

        $siswa = $query->paginate(20);

        // Get distinct values for dropdowns
        $unitOptions = Siswa::distinct()->pluck('unit_formal')->filter()->sort()->values();
        $kelasOptions = Siswa::distinct()->pluck('kelas_formal')->filter()->sort()->values();
        $asramaOptions = Siswa::distinct()->pluck('asrama_pondok')->filter()->sort()->values();
        $kamarOptions = Siswa::distinct()->pluck('kamar_pondok')->filter()->sort()->values();
        $tingkatOptions = Siswa::distinct()->pluck('tingkat_diniyah')->filter()->sort()->values();
        $kelasDiniyahOptions = Siswa::distinct()->pluck('kelas_diniyah')->filter()->sort()->values();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.siswa.table', compact('siswa'))->render(),
                'pagination' => $siswa->links()->render()
            ]);
        }

        return view('admin.siswa.index', compact('siswa', 'unitOptions', 'kelasOptions', 'asramaOptions', 'kamarOptions', 'tingkatOptions', 'kelasDiniyahOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idperson' => 'required|unique:siswa',
            'nama' => 'required',
            'no_hp_asli' => 'required',
        ]);

        $validated['no_hp_aktif'] = $validated['no_hp_asli'];
        $validated['unit_formal'] = $request->unit_formal;
        $validated['kelas_formal'] = $request->kelas_formal;
        $validated['asrama_pondok'] = $request->asrama_pondok;
        $validated['kamar_pondok'] = $request->kamar_pondok;
        $validated['tingkat_diniyah'] = $request->tingkat_diniyah;
        $validated['kelas_diniyah'] = $request->kelas_diniyah;

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'no_hp_asli' => 'required',
        ]);

        $validated['unit_formal'] = $request->unit_formal;
        $validated['kelas_formal'] = $request->kelas_formal;
        $validated['asrama_pondok'] = $request->asrama_pondok;
        $validated['kamar_pondok'] = $request->kamar_pondok;
        $validated['tingkat_diniyah'] = $request->tingkat_diniyah;
        $validated['kelas_diniyah'] = $request->kelas_diniyah;

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }

    public function toggle(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->is_toggled = !$siswa->is_toggled;
        $siswa->toggled_at = $siswa->is_toggled ? now() : null;
        $siswa->save();

        return response()->json([
            'success' => true,
            'is_toggled' => $siswa->is_toggled
        ]);
    }

    public function updatePhone(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'no_hp_asli' => 'required|string|max:255',
        ]);

        try {
            // Parse phone format: "085748799794 - ayah" or just "085748799794"
            $rawPhone = $validated['no_hp_asli'];
            $parts = array_map('trim', explode(' - ', $rawPhone, 2));
            $phoneNumber = $parts[0];
            $pemilik = $parts[1] ?? 'ibu'; // Default to 'ibu' if not specified

            // Validate pemilik must be 'ayah' or 'ibu'
            if (!in_array($pemilik, ['ayah', 'ibu'])) {
                return redirect()->route('admin.siswa.index')->with('error', 'Format pemilik harus "ayah" atau "ibu"');
            }

            // Update phone number via API
            $apiService = new ApiService();
            $apiService->updateTelepon($siswa->idperson, $pemilik, $phoneNumber);

            // Sync this specific student from API to get updated data
            $this->syncSingleSiswa($siswa->idperson);

            return redirect()->route('admin.siswa.index')->with('success', 'Nomor HP berhasil diubah di server dan data disinkronkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal mengubah nomor HP: ' . $e->getMessage());
        }
    }

    /**
     * Sync single student data from API
     */
    private function syncSingleSiswa(string $idperson)
    {
        $response = \Http::withHeaders([
            'Accept' => 'application/json',
        ])->withCookies([
                    'SWN' => env('API_SWN'),
                ], 'api.daruttaqwa.or.id')
            ->get('https://api.daruttaqwa.or.id/sisda/v1/siswa');

        if ($response->successful()) {
            $rawData = $response->json();
            $data = $rawData['data'] ?? [];

            // Find the specific student in API response
            foreach ($data as $item) {
                if (($item['idperson'] ?? '') === $idperson) {
                    // Parse phone format: "085808300856 - ayah" or "085755096782 - ibu, 085852888002 - ayah" or null
                    $rawPhone = $item['phone'] ?? null;
                    $phoneData = null;
                    $pemilik = null;

                    if ($rawPhone) {
                        // Split by comma first (for multiple phones)
                        $phoneEntries = array_map('trim', explode(',', $rawPhone));

                        // Take the first entry and parse it
                        $firstEntry = $phoneEntries[0];
                        $parts = array_map('trim', explode(' - ', $firstEntry, 2));
                        $phoneData = $parts[0] ?: null;
                        $pemilik = $parts[1] ?? null; // "ayah" / "ibu" / null
                    }

                    Siswa::updateOrCreate(
                        ['idperson' => $item['idperson'] ?? ''],
                        [
                            'nama' => $item['nama'] ?? '',
                            'no_hp_asli' => $phoneData,
                            'no_hp_aktif' => $phoneData,
                            'no_hp_pemilik' => $pemilik,
                            'unit_formal' => $item['UnitFormal'] ?? null,
                            'kelas_formal' => $item['KelasFormal'] ?? null,
                            'asrama_pondok' => $item['AsramaPondok'] ?? null,
                            'kamar_pondok' => $item['KamarPondok'] ?? null,
                            'tingkat_diniyah' => $item['TingkatDiniyah'] ?? null,
                            'kelas_diniyah' => $item['KelasDiniyah'] ?? null,
                        ]
                    );
                    break;
                }
            }
        }
    }
}
