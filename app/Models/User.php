<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'address',
        'number_phone',
        'sex',
        'status',
        'content_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // tương tác 1*
    public function hasLiked(Diarys $diary) {
        return $this->likes()->where('diary_id', $diary->id)->exists();
    }
    // 2*
    public function likes() {
        return $this->hasMany(Interacts::class);
    }


    public function Comments() {
        return $this->hasMany(Comments::class);
    }

    public function follow() {
        return $this->hasMany(Follow::class,'user1_id','id');
    }

}
