<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
   protected $fillable = [
      'title', 'body', 'workshop_key', 'user_id' , 'participants','participated','voted','locked',
  ];
  
   public function users(){
      return $this->belongsToMany('App\User','cards');
  }

  public function user(){
     return $this->belongsTo('App\User');
  }

   // public function cards(){
   //    return $this->belongsToMany('App\cards','votings');
   // }
}
