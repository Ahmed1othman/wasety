<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $appends = ['photo','name'];

 


    public function getNameAttribute()
    {
        return $this->attributes['first_name'] .' '. $this->attributes['last_name'];
    }

    public function getPhotoAttribute()
    {
        return $this->attributes['image'] != null ? asset('storage/users/' . $this->attributes['image']) : null;
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country','id');
    }

    public function city()
    {
        return $this->hasOne('App\Models\City','id');
    }

    public function rateable()
    {
        return $this->morphMany('App\Models\Rate', 'rateable');
    }

}
