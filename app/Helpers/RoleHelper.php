<?php

namespace App\Helpers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    public static function getActiveRole(): ?Role
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $activeRoleId = session('active_role_id');
        
        if ($activeRoleId) {
            $role = $user->roles()->where('roles.id', $activeRoleId)->first();
            if ($role) {
                return $role;
            }
        }

        // Default to first role if no active role set
        return $user->roles()->first();
    }

    public static function userActiveRole(): string
    {
        $role = self::getActiveRole();
        return $role?->name ?? 'guest';
    }

    public static function userActiveRoleLabel(): string
    {
        $role = self::getActiveRole();
        return $role?->label ?? 'Guest';
    }
}
