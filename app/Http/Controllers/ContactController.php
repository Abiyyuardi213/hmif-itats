<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.kontak');
    }

    public function store(Request $request): RedirectResponse
    {
        // Honeypot check to silently drop automated spam submissions.
        if ($request->filled('website')) {
            return redirect()->route('kontak')->with('success', 'Pesan Anda telah kami terima.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:160'],
            'subject' => ['required', 'string', 'min:4', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.min' => 'Isi pesan minimal 10 karakter.',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('kontak')->with('success', 'Pesan berhasil dikirim ke pengurus HMIF ITATS. Terima kasih atas aspirasi Anda.');
    }
}
