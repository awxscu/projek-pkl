<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Replace plus (+) or spaces inside role string if passed through route
        $role = str_replace('+', ' ', $role);
        
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
