<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'label'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')->withTimestamps();
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'role_module_access')
            ->withPivot(['can_view', 'can_create', 'can_edit', 'can_delete'])
            ->withTimestamps();
    }

    public function hasModuleAccess(string $moduleKey, string $action = 'can_view'): bool
    {
        return $this->modules()
            ->where('key', $moduleKey)
            ->wherePivot($action, true)
            ->exists();
    }

    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }
}
