<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:255'],
            'foto_sim' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'max:10'],
        ]);

        $data = $request->only(['name', 'alamat', 'no_hp', 'email', 'role']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto_sim')) {
            $data['foto_sim'] = $request->file('foto_sim')
                ->store('uploads/foto_sim', 'public');
        }

        $user = User::create($data);
        // $user = User::create([
        //     'name' => $request->name,
        //     'alamat' => $request->alamat,
        //     'no_hp' => $request->no_hp,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'role' => $request->role,
        // ]);

        event(new Registered($user));

        return redirect(route('users.index', absolute: false));
    }
}
