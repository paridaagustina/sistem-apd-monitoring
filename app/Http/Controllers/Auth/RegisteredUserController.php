<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'worker_code' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:workers,worker_code'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {

            // Membuat akun login pekerja
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pekerja_lapangan',
            ]);

            // Membuat data pekerja secara otomatis
            Worker::create([
                'user_id' => $user->id,
                'worker_code' => $request->worker_code,
                'name' => $request->name,
                'department' => $request->department,
                'position' => $request->position,
                'is_active' => true,
            ]);

            return $user;
        });

        event(new Registered($user));

        auth()->login($user);

        return redirect(route('pekerja.dashboard', absolute: false));
    }
}
