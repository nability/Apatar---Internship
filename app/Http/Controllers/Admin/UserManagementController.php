<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::orderBy('label')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync($validated['roles'] ?? []);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "User {$user->name} berhasil dibuat.",
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 201);
        }

        return back()->with('status', "User {$user->name} berhasil dibuat.");
    }

    public function updateRoles(Request $request, User $user): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        if ($user->is(auth()->user())) {
            $adminRole = Role::where('name', 'admin')->value('id');

            if (! in_array($adminRole, $validated['roles'] ?? [], true)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Role admin pada akun Anda sendiri tidak dapat dihapus.',
                    ], 422);
                }

                return back()->withErrors(['roles' => 'Role admin pada akun Anda sendiri tidak dapat dihapus.']);
            }
        }

        $user->roles()->sync($validated['roles'] ?? []);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "Role {$user->name} berhasil diperbarui.",
            ]);
        }

        return back()->with('status', "Role {$user->name} berhasil diperbarui.");
    }
}