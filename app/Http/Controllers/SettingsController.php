<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        // Cek apakah file settings.json ada
        if (Storage::disk('local')->exists('settings.json')) {
            // Baca file settings.json
            $data = json_decode(Storage::disk('local')->get('settings.json'), true);
            // Dapatkan nilai interval, jika tidak ada set default menjadi 5 detik
            $screenshot_interval = $data['screenshot_interval'] ?? 5;
        } else {
            // Set default jika file JSON belum ada
            $screenshot_interval = 5;
        }

        return view('Beranda.settings', compact('screenshot_interval'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'screenshot_interval' => 'required|integer|min:1',
        ]);

        $data = [
            'screenshot_interval' => $request->screenshot_interval,
        ];

        // Simpan data dalam file JSON
        Storage::disk('local')->put('settings.json', json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('settings.index')->with('success', 'Interval berhasil diperbarui.');
    }
}
