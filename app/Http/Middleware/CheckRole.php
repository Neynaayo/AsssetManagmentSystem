<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Please log in first.');
        }

        $userRoleId  = Auth::user()->roleid; // Assuming 'roleid' is your role column

        // Check if the user's role is allowed
        if (!in_array($userRoleId, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
