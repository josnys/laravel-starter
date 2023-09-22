<?php

declare(strict_types=1);

namespace Domains\User\Services;

use App\Http\Resources\Domains\User\PermissionResource;
use App\Http\Resources\Domains\User\RoleResource;
use Domains\User\Models\Permission;
use Domains\User\Models\Role;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class AuthorizationService
{
     public function getAllPermissionPaginate(int $qty_per_page) : AnonymousResourceCollection
     {
          return PermissionResource::collection(Permission::paginate($qty_per_page));
     }

     public function getPermissionBySlug(string $slug) : PermissionResource
     {
          return PermissionResource::make(Permission::where('slug', $slug)->first());
     }

     public function getAllRolePaginate(int $qty_per_page) : AnonymousResourceCollection
     {
          return RoleResource::collection(Role::paginate($qty_per_page));
     }

     public function getRoleBySlug(string $slug) : RoleResource
     {
          return RoleResource::make(Role::where('slug', $slug)->first());
     }
}