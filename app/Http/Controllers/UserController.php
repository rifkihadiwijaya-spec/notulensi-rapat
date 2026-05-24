<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User; // PERBAIKAN: typo "app\Models\User" → "App\Models\User"

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        // Otorisasi & validasi sudah ditangani StoreUserRequest

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Otorisasi & validasi sudah ditangani UpdateUserRequest

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
            ...($request->filled('password') ? ['password' => bcrypt($request->password)] : []),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User dihapus');
    }
}