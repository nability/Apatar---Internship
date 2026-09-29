<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $moduleKey
     * @param  string  $action
     */
    public function handle(Request $request, Closure $next, string $moduleKey, string $action = 'can_view'): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        $hasAccess = \App\Models\RoleModuleAccess::query()
            ->whereIn('role_id', $user->roleIds())
            ->whereHas('module', fn ($query) => $query->where('key', $moduleKey))
            ->where($action, true)
            ->exists();

        if ($hasAccess) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses untuk membuka modul ini.');
    }
}
