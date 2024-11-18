<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function destroy($id)
    {
        // Cari screenshot berdasarkan ID
        $screenshot = Screenshot::find($id);

        if (!$screenshot) {
            return redirect()->back()->with('Screenshot tidak ditemukan', 404);
        }

        // Path ke file dari kolom image_ss di database
        $filePath = 'public/' . $screenshot->image_ss;

        // Hapus file dari penyimpanan jika ditemukan
        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
        } else {
            return redirect()->back()->with('File tidak ditemukan di penyimpanan', 404);
        }

        // Hapus dari database
        $screenshot->delete();
    }
    public function destroyByDeviceName($deviceName)
    {
        $screenshots = Screenshot::where('name_device', $deviceName)->get();

        if ($screenshots->isEmpty()) {
            return redirect()->back()->with('Tidak ada screenshot ditemukan untuk perangkat tersebut', 404);
        }

        foreach ($screenshots as $screenshot) {
            // Path ke file dari kolom image_ss di database
            $filePath = 'public/' . $screenshot->image_ss;

            // Hapus file dari penyimpanan jika ditemukan
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
        }

        // Hapus semua data dari database dengan name_device yang sama
        Screenshot::where('name_device', $deviceName)->delete();

        return redirect()->back()->with('Semua screenshot untuk perangkat berhasil dihapus', 200);
    }
}
