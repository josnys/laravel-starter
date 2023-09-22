<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'slug',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }
}
