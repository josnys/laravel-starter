<?php

declare(strict_types=1);

namespace Domains\User\Services;

use App\Http\Resources\Domains\User\UserResource;
use Domains\User\Models\Role;
use Domains\User\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class UserService
{
     public function getAllPaginate() : AnonymousResourceCollection
     {
          return UserResource::collection(User::with('person')->paginate(50));
     }

     public function getByUsername(string $username) : UserResource
     {
          return new UserResource(User::with('person')->where('username', $username)->first());
     }

     public function getUserRolleAssign(string $username) : array
     {
          $user = User::with('roles')->where('username', $username)->first();

          $user_roles = $user->roles->pluck('id')->toArray();
          return [
               'roles' => Role::active()->get()->map(function($role) use ($user_roles) {
                    return [
                         'id' => $role->id,
                         'display_name' => $role->display_name,
                         'slug' => $role->slug,
                         'description' => $role->description,
                         'is_checked' => in_array($role->id, $user_roles)
                    ];
               }),
               'user_roles' => $user->roles->pluck('display_name')->join(', '),
               'user' => UserResource::make($user)
          ];
     }
}