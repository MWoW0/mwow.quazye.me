<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Authenticatable implements AuditableContract, MustVerifyEmail
{
    use Auditable, SoftDeletes, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'account_name', 'type', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar_url'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    /**
     * Get the game accounts of the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameAccounts(): HasMany
    {
        return $this->hasMany(GameAccount::class, 'user_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'?s=300';
    }
}
