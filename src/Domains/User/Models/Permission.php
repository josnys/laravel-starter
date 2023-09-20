<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_permissions');
    }
}