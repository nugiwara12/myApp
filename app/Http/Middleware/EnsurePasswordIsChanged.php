<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}