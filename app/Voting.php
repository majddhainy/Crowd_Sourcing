<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    public function cards(){
        return $this->hasMany(Card::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
