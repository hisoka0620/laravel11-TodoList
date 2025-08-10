<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(UserRegistrationRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Your registration is complete!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(UserLoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Incorrect email.'])->withInput();
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        $remember = $request->filled('remember');

        Auth::login($user, $remember);

        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
