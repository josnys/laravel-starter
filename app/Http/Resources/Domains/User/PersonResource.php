<?php

declare(strict_types=1);

namespace App\Http\Resources\Domains\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => "{$this->firstname} {$this->lastname}",
            'dob' => $this->dob,
            // 'dob_display' => $this->dob->format('M d, Y'),
            'bio' => $this->bio,
            'address' => $this->address,
            'phone' => $this->phone,
            'avatar' => [
                'small' => $this->small_avatar,
                'large' => $this->large_avatar
            ]
        ];
    }
}
