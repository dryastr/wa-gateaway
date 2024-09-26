<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $message = $request->input('message');

        // Logika untuk mengirim pesan menggunakan wwebjs
        // Misalnya, kirim pesan ke service yang Anda gunakan

        return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim.']);
    }
}
