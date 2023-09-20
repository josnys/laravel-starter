<?php

declare(strict_types=1);

namespace App\Http\Resources\Domains\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'related' => [
                'person' => PersonResource::make($this->whenLoaded('person'))
            ]
        ];
    }
}
