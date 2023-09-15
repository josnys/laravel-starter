<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Database\Factories\PersonFactory;
use Domains\User\Models\Concerns\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasCode;
    use HasFactory;

    protected $fillable = [
        'code',
        'firstname',
        'lastname',
        'dob',
        'bio',
        'address',
        'phone',
        'profile_url',
        'is_active',
        'is_banned',
    ];

    protected $cast =[
        'dob' => 'datetime',
        'is_active' => 'boolean',
        'is_banned' => 'boolean'
    ];

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'person_id');
    }

    protected static function newFactory()
    {
        return new PersonFactory();
    }
}
