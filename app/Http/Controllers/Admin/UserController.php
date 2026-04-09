<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $editingUser = $request->integer('edit') ? User::findOrFail($request->integer('edit')) : null;

        return view('admin.users', [
            'users' => User::latest()->get(),
            'editingUser' => $editingUser,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'instansi' => $data['instansi'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
            'foto_profil' => $data['foto_profil'] ?? null,
        ]);

        return back()->with('status', 'Akun berhasil ditambahkan.');
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'role' => $data['role'],
            'instansi' => $data['instansi'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
            'foto_profil' => $data['foto_profil'] ?? null,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        return back()->with('status', 'Akun berhasil diperbarui.');
    }

    public function resetPassword(User $user): RedirectResponse
    {
        $user->update([
            'password' => Hash::make('password123'),
        ]);

        return back()->with('status', 'Password berhasil direset menjadi password123.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->id === auth()->id(), 403, 'Tidak bisa menghapus akun sendiri.');

        $user->delete();

        return back()->with('status', 'Akun berhasil dihapus.');
    }
}
