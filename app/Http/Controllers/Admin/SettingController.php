<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'return_duration_minutes' => Setting::get('return_duration_minutes', 15),
            'api_sync_interval_minutes' => Setting::get('api_sync_interval_minutes', 60),
            'api_cookie' => Setting::get('api_cookie', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'return_duration_minutes' => 'required|integer|min:1',
            'api_sync_interval_minutes' => 'required|integer|min:1',
            'api_cookie' => 'required|string',
        ]);

        Setting::set('return_duration_minutes', $request->return_duration_minutes);
        Setting::set('api_sync_interval_minutes', $request->api_sync_interval_minutes);
        Setting::set('api_cookie', $request->api_cookie);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
