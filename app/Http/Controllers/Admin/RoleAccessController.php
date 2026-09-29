<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role;
use App\Models\RoleModuleAccess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleAccessController extends Controller
{
    public function index(): View
    {
        $roles = Role::where('name', '!=', 'admin')->orderBy('label')->get();
        $modules = Module::orderBy('sidebar_order')->get();

        return view('admin.access.index', compact('roles', 'modules'));
    }

    public function update(Request $request, Role $role): RedirectResponse|JsonResponse
    {
        abort_if($role->isAdmin(), 403, 'Akses admin utama tidak dapat diubah.');

        $validated = $request->validate([
            'modules' => ['nullable', 'array'],
            'modules.*.id' => ['required', 'integer', 'exists:modules,id'],
            'modules.*.can_create' => ['nullable', 'boolean'],
            'modules.*.can_edit' => ['nullable', 'boolean'],
            'modules.*.can_delete' => ['nullable', 'boolean'],
        ]);

        $access = collect($validated['modules'] ?? [])->mapWithKeys(function (array $module) {
            return [
                $module['id'] => [
                    'can_view' => true,
                    'can_create' => (bool) ($module['can_create'] ?? false),
                    'can_edit' => (bool) ($module['can_edit'] ?? false),
                    'can_delete' => (bool) ($module['can_delete'] ?? false),
                ],
            ];
        })->all();

        RoleModuleAccess::where('role_id', $role->id)->delete();

        foreach ($access as $moduleId => $permissions) {
            RoleModuleAccess::create(array_merge($permissions, [
                'role_id' => $role->id,
                'module_id' => $moduleId,
            ]));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "Akses {$role->label} berhasil diperbarui.",
            ]);
        }

        return back()->with('status', "Akses {$role->label} berhasil diperbarui.");
    }
}