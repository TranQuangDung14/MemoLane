<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interacts extends Model
{
    use HasFactory;
    protected $table='ml_interacts';

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function diary() {
        return $this->belongsTo(Diarys::class,'diary_id');
    }
}
