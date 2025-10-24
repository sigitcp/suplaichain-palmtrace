<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roleName)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        // mapping role_name -> role_id
        $roles = [
            'admin' => 1,
            'petani' => 2,
            'pengepul' => 3,
            'pks' => 4,
            'refinery' => 5,
        ];

        if (!isset($roles[$roleName]) || $user->role_id != $roles[$roleName]) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
