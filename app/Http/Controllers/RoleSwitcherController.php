<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleSwitcherController extends Controller
{
    public function switch(Request $request, Role $role): RedirectResponse
    {
        $user = $request->user();

        // Verify user has this role
        if (!$user->roles()->where('roles.id', $role->id)->exists()) {
            abort(403, 'Anda tidak memiliki role ini.');
        }

        // Store active role in session
        session(['active_role_id' => $role->id]);

        return redirect()->route('dashboard')->with('status', "Berganti ke {$role->label}");
    }
}
