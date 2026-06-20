<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petugas;

class ProfileController extends Controller
{
    public function edit()
    {
        $petugas = Petugas::where('user_id', auth()->id())->firstOrFail();
        return view('petugas.profil', compact('petugas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        $petugas = Petugas::where('user_id', auth()->id())->firstOrFail();
        $petugas->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('petugas.profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
