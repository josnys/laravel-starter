<?php

declare(strict_types=1);

namespace Domains\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_suspended',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_banned' => 'boolean'
    ];

    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    protected static function newFactory()
    {
        return new UserFactory();
    }
}
