<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\manajemen\TasksController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('tasks', TasksController::class);
});

Route::get('/whatsapp/qr', function () {
    return view('whatsapp.qr');
});
Route::post('/send-message', function (Request $request) {
    // Validasi input
    $request->validate([
        'phone' => 'required|string',
        'message' => 'required|string',
    ]);

    // Mengirim pesan menggunakan wwebjs
    $phone = $request->input('phone');
    $message = $request->input('message');

    // Gantilah dengan logika pengiriman pesan menggunakan wwebjs
    try {
        // Contoh logika untuk mengirim pesan (ubah sesuai dengan implementasi wwebjs Anda)
        // Misalkan Anda memiliki script Node.js untuk mengirim pesan WhatsApp
        $response = Http::post('http://localhost:3000/send', [
            'phone' => $phone,
            'message' => $message,
        ]);

        // Periksa apakah pengiriman berhasil
        if ($response->successful()) {
            return response()->json(['status' => 'success', 'message' => 'Pesan berhasil dikirim.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim pesan.'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    }
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');
});

// Contoh
// Route::get('/', function () {
//     if (Auth::check()) {
//         $user = Auth::user();
//         if ($user->role->name === 'super_admin') {
//             return redirect()->route('super_admin.dashboard');
//         } elseif ($user->role->name === 'admin') {
//             return redirect()->route('admin.dashboard');
//         } elseif ($user->role->name === 'kaprog') {
//             return redirect()->route('kaprog.dashboard');
//         } elseif ($user->role->name === 'pemray') {
//             return redirect()->route('pemray.dashboard');
//         } else {
//             return redirect()->route('home');
//         }
//     }
//     return redirect()->route('login');
// })->name('home');
