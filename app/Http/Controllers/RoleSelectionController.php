<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleSelectionController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $user = auth()->user();

        // If user doesn't have multiple roles, redirect to dashboard
        if ($user->roles()->count() <= 1) {
            return redirect()->route('dashboard');
        }

        $roles = $user->roles()->get();

        return view('role-selection', compact('roles'));
    }

    public function select(Request $request): RedirectResponse
    {
        $user = $request->user();
        $roleId = $request->input('role_id');

        // Verify user has this role
        if (!$user->roles()->where('roles.id', $roleId)->exists()) {
            return back()->withErrors(['role_id' => 'Role tidak valid.']);
        }

        session(['active_role_id' => $roleId]);

        return redirect()->route('dashboard');
    }
}
