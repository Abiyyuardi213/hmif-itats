<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()->latest('id')->paginate(20);

        return view('admin.pesan.index', compact('messages'));
    }

    public function markRead(ContactMessage $pesan): RedirectResponse
    {
        $pesan->update(['status' => 'read']);

        return redirect()->route('admin.pesan.index')->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(ContactMessage $pesan): RedirectResponse
    {
        $pesan->delete();

        return redirect()->route('admin.pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
