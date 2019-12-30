<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{

   protected $fillable = [
      'title', 'body', 'workshop_key', 'user_id' , 'participants','participated','voted','locked',
  ];
    public function user(){
        return $this->belongsTo(User::class);
     }

     public function card(){
        return $this->belongsTo(Card::class);
     }
}
