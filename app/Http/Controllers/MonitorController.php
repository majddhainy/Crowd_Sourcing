<?php

namespace App\Http\Controllers;
use App\Workshop;
use App\Card;
use App\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MonitorController extends Controller
{
    public function __construct(){
        $this->middleware('monitorplus')->only(['monitorworkshop','joindoor','takecards','takescores','shuffilecards','results','chooseprojects']);
    }
    public function createworkshop() {
        return view('monitor.createworkshop');
    }

    public function storeworkshop() {
        $workshop = request()->validate([
            'title' => 'string|required|max:50',
            'body' => 'required|max:500',
            'participants' => 'integer:min:6'
        ]);

        $workshop['workshop_key'] = Hash::make($workshop['title']);
        $workshop['user_id'] = auth()->user()->id;
        
        $workshop = Workshop::create($workshop);

        session()->flash('success','Workshop Created Successfuly');
        return redirect(route('monitorworkshop' , $workshop->id));
    }
    public function monitorworkshop(Workshop $workshop) { //added
        return view('monitor.monitorworkshop',[
            'users'=>$workshop->users,
            'workshop'=>$workshop
       ]);
    }
    public function joindoor(Workshop $workshop){ // added
        if($workshop->locked==0){
            $workshop->locked=1;
            session()->flash('success','Workshop Door Opened Succefully');
         }
        else{
            $workshop->locked=0;
            session()->flash('success','Workshop Door Closed Succefully');
        }
        $workshop->save();
        return redirect(route('monitorworkshop',$workshop->id));
    }
    public function takecards(Workshop $workshop){ // added
        if($workshop->locked==1){
        $workshop->can_submit=1;
        $workshop->save();
        return view('monitor.takecards',[
            'workshop'=>$workshop
            ]);
        }
    }
    public function takescores(Workshop $workshop){
        if($workshop->locked==1){
        $workshop->can_submit=0;
        $workshop->save();
        return view('monitor.takescores',[
            'workshop'=>$workshop
        ]);
        }
    }
    public function shuffilecards(Workshop $workshop){ //added
        $workshop->voted=0;
        $workshop->can_vote=1;
        $workshop->save();
        $users=$workshop->users; //array of particpants of this workshop
        $cards=Card::where('workshop_id',$workshop->id)->get(); //array of votings associated to this workshop
        $takenCards=Collect(new Card);
        $currentVotes=(Collect(new Voting))->values();
        foreach($users as $user){
            $user->can_vote=1;
            $user->save();
            $votings=Voting::where([['user_id',$user->id],['workshop_id',$workshop->id]])->get();
            $votedCards=Collect(new Card);
            foreach($votings as $vote)
                $votedCards->push(Card::where('id',$vote->card_id)->first());
            $votedCards->push(Card::where([['workshop_id',$workshop->id],['user_id',$user->id]])->first());
            $availableCards=($cards->diff($votedCards))->diff($takenCards);
            $availableCards=$availableCards->values();
            if($availableCards==null||$availableCards->count()==0){ // must delete uploaded votes
                foreach($currentVotes as $v)
                    $v->delete();
                $currentVotes=(Collect(new Voting))->values();
                return $this->shuffilecards($workshop);
            }
            $random=rand(0,($availableCards->count())-1);
            $currentVotes->push(Voting::create([
                'user_id'=>$user->id,
                'card_id'=>$availableCards[$random]->id,
                'workshop_id'=>$workshop->id
            ]));
            $takenCards->push($availableCards[$random]);
        }
        return redirect(route('takescores',$workshop->id));
    }
    public function results(Workshop $workshop){ //added
        if(!$workshop->finshed)
            return redirect(route('takescores',$workshop->id));
        $cards=Card::where('workshop_id',$workshop->id)->orderBy('score','desc')->get();
        return view('monitor.results',[
            'cards'=>$cards,
            'workshop'=>$workshop
        ]);
    }
    public function chooseprojects(Workshop $workshop){ // added
        //TODO
        return redirect(route('chooseprojects',$workshop->id));
    }

}
