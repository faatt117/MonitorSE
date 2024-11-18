<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function show($id)
    {
        // Ambil detail perangkat berdasarkan ID
        $user = User::findOrFail($id);
        // Kembalikan data dalam format JSON
        return response()->json([
            'id' => $user->id,
            'name' => $user->name_device,
            'status' => $user->status_device,
        ]);
    }
}
