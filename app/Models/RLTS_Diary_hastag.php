<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RLTS_Diary_hastag extends Model
{
    use HasFactory;
    protected $table ="diary_hashtags";

    public function diary() {
        return $this->belongsTo(Diarys::class,'diary_id');
    }
    public function hastag() {
        return $this->belongsTo(Hastags::class,'hashtag_id');
    }

}
