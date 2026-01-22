<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(25);
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        return view('users.show', compact('users'));
    }

    public function edit($id)
    {
        $mobil = User::findOrFail($id);
        return view('users.edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        $mobil = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_sim' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'new_password' => 'nullable|string|min:8',
            'role' => 'required|string|max:10',
        ]);

        $mobil->name = $validated['name'];
        $mobil->email = $validated['email'];
        $mobil->alamat = $validated['alamat'];
        $mobil->no_hp = $validated['no_hp'];
        $mobil->role = $validated['role'];

        // 🖼️ Update foto kalau ada yang baru
        if ($request->hasFile('foto_sim')) {
            $path = $request->file('foto_sim')->store('uploads/foto_sim', 'public');
            $validated['foto_sim'] = $path;
        }

        // Hash jika ada password baru
        if ($request->filled('new_password')) {
            $mobil->password = Hash::make($validated['new_password']);
        }

        $mobil->save();

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Data User berhasil dihapus!');
    }
}
