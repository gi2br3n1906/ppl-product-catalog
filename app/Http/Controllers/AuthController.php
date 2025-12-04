<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        // If there is a redirect query parameter, forward it to the view
        return view('auth.login', [
            'redirectTo' => request()->query('redirect')
        ]);
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // If a redirect param exists (from guest 'buy' flow), redirect there.
            if ($request->filled('redirect')) {
                // basic safety: allow only internal redirects by using url()->to()
                $redirectTo = $request->input('redirect');
                return redirect()->to($redirectTo);
            }

            // Default for non-admin: redirect to intended or seller dashboard
            return redirect()->intended(route('seller.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalog')->with('success', 'Berhasil logout');
    }
}
