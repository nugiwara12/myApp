<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Pointing to resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required|captcha',
        ], [
            // 'g-recaptcha-response.required' => 'Please confirm you are not a robot.',
            // 'g-recaptcha-response.captcha' => 'Captcha verification failed, please try again.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // 🔒 EMAIL VERIFICATION CHECK
            if (! Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You must verify your email address before logging in.',
                ]);

                // OR: allow login but force verification redirect instead
                // return redirect()->route('verification.notice');
            }

            return redirect()->intended('/dashboard'); // Change route as needed
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
