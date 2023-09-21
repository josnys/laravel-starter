<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use Domains\User\DTO\UserData;
use Domains\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = User::where('username', $this->current_username)->first();

        return [
            'firstname' =>  'required|string|max:255',
            'lastname' => 'sometimes|nullable|string|max:255',
            'dob' => 'sometimes|nullable|date',
            'bio' => 'sometimes|nullable|string',
            'suspended' => 'required|boolean',
            'banned' => 'required|boolean',
        ];
    }

    public function payload() : UserData
    {
        return UserData::fromRequest(
            data: [
                'firstname' => $this->string('firstname')->toString(),
                'lastname' => $this->string('lastname')->toString(),
                'dob' => $this->string('dob')->toDate(),
                'bio' => $this->string('bio')->toString(),
                'suspended' => $this->string('suspended')->toBoolean(),
                'banned' => $this->string('banned')->toBoolean()
            ]
        );
    }
}
