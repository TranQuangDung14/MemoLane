<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarys extends Model
{
    use HasFactory;
    protected $table='ml_diarys';

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // like
    public function Interacts()
    {
        return $this->hasMany(Interacts::class,'diary_id','id');

    }
    // đếm lượt like
    public function Interacts_count()
    {
        // return $this->hasMany(Interacts::class,'diary_id','id');
        $count = $this->hasMany(Interacts::class, 'diary_id', 'id')->selectRaw('diary_id, count(*) as interact_count')->groupBy('diary_id');
        return $count;

    }
    //
    public function Comments()
    {
        return $this->hasMany(Comments::class,'diary_id','id');

    }

}
