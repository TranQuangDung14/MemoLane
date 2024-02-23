<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table='ml_notifications';

    public function user1() {
        return $this->belongsTo(User::class,'user1_id')->select(['id', 'name', 'email','avatar']);
    }
    public function user2() {
        return $this->belongsTo(User::class,'user2_id')->select(['id', 'name', 'email','avatar']);
    }
    public function diary() {
        return $this->belongsTo(Diarys::class,'diary_id');
    }
}
