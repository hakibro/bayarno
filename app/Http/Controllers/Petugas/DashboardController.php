<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class DashboardController extends Controller
{
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

        // Order by toggle status: active toggles first, then by name
        $query->leftJoin('toggle_history', function ($join) {
            $join->on('siswa.id', '=', 'toggle_history.siswa_id')
                ->whereNull('toggle_history.returned_at');
        })
            ->select('siswa.*')
            ->orderByRaw('CASE WHEN toggle_history.id IS NOT NULL THEN 0 ELSE 1 END')
            ->orderBy('siswa.nama');

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
                'html' => view('petugas.table', compact('siswa'))->render(),
                'pagination' => $siswa->links()->render()
            ]);
        }

        return view('petugas.dashboard', compact('siswa', 'unitOptions', 'kelasOptions', 'asramaOptions', 'kamarOptions', 'tingkatOptions', 'kelasDiniyahOptions'));
    }

    public function getKelasByUnit(Request $request)
    {
        $kelas = Siswa::where('unit_formal', $request->unit)
            ->distinct()
            ->pluck('kelas_formal')
            ->filter()
            ->sort()
            ->values();

        return response()->json($kelas);
    }

    public function getKamarByAsrama(Request $request)
    {
        $kamar = Siswa::where('asrama_pondok', $request->asrama)
            ->distinct()
            ->pluck('kamar_pondok')
            ->filter()
            ->sort()
            ->values();

        return response()->json($kamar);
    }

    public function getKelasByTingkat(Request $request)
    {
        $kelas = Siswa::where('tingkat_diniyah', $request->tingkat)
            ->distinct()
            ->pluck('kelas_diniyah')
            ->filter()
            ->sort()
            ->values();

        return response()->json($kelas);
    }
}
