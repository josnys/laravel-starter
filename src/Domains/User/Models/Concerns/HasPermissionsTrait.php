<?php

declare(strict_types=1);

namespace Domains\User\Models\Concerns;

use Domains\User\Models\Permission;
use Domains\User\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissionsTrait
{
     public function assignPermissions(array ...$permissions) : self
     {
          $permissions = $this->getAllPermissions($permissions);

          if ($permissions !== null)
          {
               $this->permissions()->saveMany($permissions);
          }
          
          return $this;
     }

     public function removePermissions(array ...$permissions) : self
     {
          $permissions = $this->getAllPermissions($permissions);
          $this->permissions()->detach($permissions);

          return $this;
     }

     public function refreshPermissions(array ...$permissions) : self
     {
          $this->permissions()->detach();

          return $this->givePermissionsTo($permissions);
     }

     public function hasPermissionTo(Permission $permission) : bool
     {
          return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
     }

     public function hasPermissionThroughRole($permission) : bool
     {
          foreach($permission->roles as $role)
          {
               if($this->roles->contains($role))
               {
                    return true;
               }
          }
          return false;
     }

     public function hasRole(array ...$roles) : bool
     {
          foreach($roles as $role)
          {
               if($this->roles->contains('slug', $role))
               {
                    return true;
               }
          }

          return false;
     }

     public function roles() : BelongsToMany
     {
          return $this->belongsToMany(Role::class, 'users_roles');
     }

     public function permissions() : BelongsToMany
     {
          return $this->belongsToMany(Permission::class, 'users_permissions');
     }

     public function hasPermission(Permission $permission) : bool
     {
          return (bool) $this->permissions()->where('slug', $permission->slug)->count();
     }
}
