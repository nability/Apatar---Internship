<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\RoleHelper;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            abort(403);
        }

        // Check if user is admin or active role is admin
        if ($user->isAdmin()) {
            return $next($request);
        }

        $activeRole = RoleHelper::getActiveRole();
        
        if ($activeRole && $activeRole->isAdmin()) {
            return $next($request);
        }

        abort(403);
    }
}