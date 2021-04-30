<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName',
        'category',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    public function getJWTCustomClaims() {
        return [];
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function content(){
        return $this->hasMany(content::class, 'postedBy', 'id');
    }
    public function profile(){
        return $this->hasOne(Profile:: class, 'userId', 'id');
    }
    public function subscribe(){
        return $this->hasMany(Subscriber:: class, 'subscribeTo', 'id');
    }
    public function userSubscriber(){
        return $this->hasMany(Subscriber::class,'','');
    }
}
