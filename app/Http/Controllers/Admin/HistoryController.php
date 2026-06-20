<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ToggleHistory;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ToggleHistory::with(['siswa', 'petugas.user']);

        if ($request->filled('petugas_id')) {
            $query->where('petugas_id', $request->petugas_id);
        }

        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereNull('returned_at');
            } else {
                $query->whereNotNull('returned_at');
            }
        }

        $history = $query->orderBy('created_at', 'desc')->paginate(20);

        $petugasList = \App\Models\Petugas::with('user')->get();

        return view('admin.history', compact('history', 'petugasList'));
    }
}
