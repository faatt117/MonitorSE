<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Api\ScreenshotController;
use App\Http\Controllers\DestroyController;
use App\Http\Controllers\SettingsController;
use App\Models\User;


// Route untuk halaman beranda (daftar perangkat)
Route::get('/beranda', function () {
    $user = User::all();
    //dd($user);  // Pastikan $user berisi data yang benar
    return view('beranda.index', [
        'user' => $user,
    ]);
})->name('beranda.index');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/detail/{name_device}', [ScreenshotController::class, 'deviceDetail'])->name('beranda.detail');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');


Route::post('/api/upload-screenshot', [ScreenshotController::class, 'store']);
Route::post('/api/online', [ScreenshotController::class, 'storeStatus']);

Route::delete('/delete-screenshot/{id}', [DestroyController::class, 'destroy']);
Route::delete('/delete-screenshot-bydevice/{deviceName}', [DestroyController::class, 'destroyByDeviceName']);
