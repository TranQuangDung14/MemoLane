<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table='ml_comments';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function diary() {
        return $this->belongsTo(Diarys::class,'diary_id');
    }
}
