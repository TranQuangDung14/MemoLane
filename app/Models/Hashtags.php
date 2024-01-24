<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtags extends Model
{
    use HasFactory;
    protected $table='ml_hashtags';

    public function relationship_diary() {
        return $this->hasMany(RLTS_Diary_hastag::class,'hashtag_id','id');
    }
}
