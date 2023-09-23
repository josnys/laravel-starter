<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
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

    public function scopeActive($query) : Builder
    {
        return $query->where('is_active', true);
    }

    public static function userAccess(): array
    {
        return [
            'add_new' => request()->user()->can('create-role'),
            'edit' => request()->user()->can('update-role'),
            // 'add_permissions' => request()->user()->can(''),
        ];
    }
}
