<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ToggleHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $petugas = auth()->user()->petugas;

        $history = ToggleHistory::with(['siswa'])
            ->where('petugas_id', $petugas->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('petugas.history', compact('history'));
    }
}
