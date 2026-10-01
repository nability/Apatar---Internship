<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\RoleHelper;

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

        $activeRole = RoleHelper::getActiveRole();

        if (!$activeRole) {
            abort(403, 'Role tidak aktif. Silakan pilih role terlebih dahulu.');
        }

        $hasAccess = \App\Models\RoleModuleAccess::where('role_id', $activeRole->id)
            ->whereHas('module', fn ($query) => $query->where('key', $moduleKey))
            ->where($action, true)
            ->exists();

        if ($hasAccess) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses untuk membuka modul ini.');
    }
}
