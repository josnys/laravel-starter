<?php

declare(strict_types=1);

namespace Domains\User\Services;

use App\Http\Resources\Domains\User\UserResource;
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
}