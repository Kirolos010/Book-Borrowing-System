<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard('admin')->user();
        //  Super Admin access everything
        if ($user->hasRole('superadmin')) {
            return $next($request);
        }
        // Check if user has the required permission
        if ($user->can($permission)) {
            return $next($request);
        }
        return redirect()->route('books.index')->with('error', 'Unauthorized access!');
    }
}
