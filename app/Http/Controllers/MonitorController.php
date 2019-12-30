<?php

namespace App\Http\Controllers;
use App\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class MonitorController extends Controller
{
    public function createworkshop() {
        return view('monitor.createworkshop');
    }

    public function storeworkshop() {
        
        $workshop = request()->validate([
        
            'title' => 'string|required|max:50',
            'body' => 'required|max:500',
            'participants' => 'integer:min:0'

        ]);

        $workshop['workshop_key'] = Hash::make($workshop['title']);
        $workshop['user_id'] = auth()->user()->id;
        
        $workshop = Workshop::create($workshop);

        session()->flash('success','Workshop Created Successfuly');
        return redirect(route('workshopstatus' , $workshop->id));


    }

    public function workshopstatus() {
       // 
    }
}
