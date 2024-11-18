<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Screenshot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScreenshotController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name_device' => 'required|string',
            'image_ss' => 'required|file|mimes:jpeg,png,jpg',
        ]);

        // Simpan screenshot ke dalam storage
        $path = $request->file('image_ss')->store('screenshots', 'public');

        // Simpan data ke database menggunakan Model Screenshot
        Screenshot::create([
            'name_device' => $request->name_device,
            'image_ss' => $path,
        ]);

        // Cek apakah name_device sudah ada di tabel Users
        $existingDevice = User::where('name_device', $request->name_device)->first();
        if (!$existingDevice) {
            // Jika tidak ada, simpan ke tabel Users
            User::create([
                'name_device' => $request->name_device,
            ]);
        }

        // Cek apakah file settings.json ada di storage
        $screenshot_interval = 5; // Default interval
        if (Storage::disk('local')->exists('settings.json')) {
            // Baca file settings.json
            $data = json_decode(Storage::disk('local')->get('settings.json'), true);
            // Dapatkan nilai interval, jika tidak ada set default menjadi 5 detik
            $screenshot_interval = $data['screenshot_interval'] ?? 5;
        }

        // Mengembalikan data sebagai respons dalam format JSON
        return response()->json([
            'screenshot_interval' => $screenshot_interval, // Menyertakan interval dalam respons
        ]);
    }

    public function deviceDetail($name_device)
    {
        // Retrieve the device by name
        $device = User::where('name_device', $name_device)->firstOrFail();

        // Get all screenshots for this specific device
        $screenshots = Screenshot::where('name_device', $name_device)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('beranda.detail', compact('device', 'screenshots'));
    }

    public function storeStatus(Request $request)
    {
        // Validasi status perangkat
        $validated = $request->validate([
            'name_device' => 'required|string',
            'status_device' => 'required|boolean',
        ]);

        // Cari perangkat berdasarkan name_device
        $device = User::where('name_device', $validated['name_device'])->first();

        if ($device) {
            // Jika perangkat ditemukan, update status_device
            $device->status_device = $validated['status_device'];
            $device->save();

            return response()->json(['message' => 'Status perangkat berhasil diperbarui'], 200);
        } else {
            // Jika perangkat tidak ditemukan
            return response()->json(['message' => 'Perangkat tidak ditemukan'], 404);
        }
    }
}
?>