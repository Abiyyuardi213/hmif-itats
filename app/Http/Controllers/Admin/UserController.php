<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()->orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:users,email'],
            'password' => ['required', 'string', 'min:10'],
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        AuditLogger::record('user.created', "Menambahkan akun pengurus {$user->email} ({$user->role})", $user);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengurus baru berhasil dibuat.');
    }

    public function toggleActive(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->id === $user->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['is_active' => ! $user->is_active]);
        AuditLogger::record('user.status_changed', "Mengubah status aktif {$user->email}", $user, ['is_active' => $user->is_active]);

        return redirect()->route('admin.users.index')->with('success', 'Status akun pengurus diperbarui.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
        ]);

        if ($request->user()->id === $user->id && $validated['role'] !== User::ROLE_SUPER_ADMIN) {
            return back()->with('error', 'Anda tidak dapat menurunkan role Super Admin Anda sendiri.');
        }

        $user->update(['role' => $validated['role']]);
        AuditLogger::record('user.role_updated', "Mengubah role {$user->email} menjadi {$validated['role']}", $user);

        return redirect()->route('admin.users.index')->with('success', 'Role pengurus berhasil diperbarui.');
    }
}
