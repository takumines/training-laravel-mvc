<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENSION = 'suspension';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * ユーザー特定のための一意な値を返却
     */
    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * JWTで利用するクレーム情報で追加したクレーム情報があれば追加する
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
