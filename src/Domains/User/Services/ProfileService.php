<?php

declare(strict_types=1);

namespace Domains\User\Services;

use App\Http\Resources\Domains\User\UserResource;
use Domains\User\Models\User;

final class ProfileService {
     /**
      * @param User $user
      */
     public function __construct(
          protected readonly User $user
     ){}

     /**
      * @return JsonResource<UserResource>
      */
     public function getUser() : UserResource
     {
          try {
               $profile = User::query()->with('person')->find($this->user->id);
               
               return new UserResource($profile);
          } catch (\Exception $e) {
               info($e);
          }
     }
}