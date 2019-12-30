<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function joinworkshop(){
        return view('participant.joinworkshop');
    }
}
