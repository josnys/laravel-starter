<?php

declare(strict_types=1);

namespace Domains\User\Services;

use App\Http\Resources\Domains\User\UserResource;
use Domains\User\Models\User;

final class ProfileService {
     public function __construct(
          protected readonly User $user
     ){}

     public function getUser() : UserResource
     {
          try {
               $profile = User::with('person')->find($this->user->id);
               
               return new UserResource($profile);
          } catch (\Exception $e) {
               info($e);
          }
     }
}