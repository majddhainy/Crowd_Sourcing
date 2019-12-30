<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function workshops(){
        return $this->hasMany(Workshop::class);
    }

    public function voting(){
        return $this->hasOne(Voting::class);
    }
}
