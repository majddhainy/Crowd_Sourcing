<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workshop;
use App\Card;
use App\Voting;
use App\User;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function __construct(){
        $this->middleware('participantplus')->only(['createcard','storecard','card','votecard','chooseproject']);
    }
    public function joinworkshop(){
        return view('participant.joinworkshop');
    }
    public function applytoworkshop(){ // added
        $workshop=Workshop::where('workshop_key',request('key'))->first();
        if($workshop==null){
            session()->flash('message','Workshop Key Not Found');
            return redirect(route('joinworkshop'));
        }
        if($workshop->locked==1){
            session()->flash('message','Cannot Join Workshop Door is closed Contact Monitor');
            return redirect(route('joinworkshop'));
        }
        if($workshop->participated==$workshop->participants){
            session()->flash('message','Workshop Is Full');
            return redirect(route('joinworkshop'));
        }
        Card::create([
            'workshop_id'=>$workshop->id,
            'user_id'=>Auth::user()->id
        ]);
        $workshop->participated++; //can send a notification here!!!!
        $workshop->save();
        return redirect(route('createcard',$workshop->id));
    }
    public function createcard(Workshop $workshop){ //added
        return view('participant.createcard',['workshop'=>$workshop]);
    }
    public function storecard(Workshop $workshop){ // added
        request()->validate([
            'title' => 'string|required|max:50',
            'body' => 'required|max:500',
        ]);
        $card=Card::where([ ['workshop_id', $workshop->id ],['user_id', Auth::user()->id]])->first();
        $card->title=request('title');
        $card->body=request('body');
        $card->save();
        $workshop->voted++;
        $workshop->save();
        Auth::user()->can_submit = 0;
        Auth::user()->save();
        return redirect(route('card' , $workshop->id));
    }
    public function card(Workshop $workshop){ // added
        $votedCards=Voting::where([['user_id',Auth::user()->id],['workshop_id',$workshop->id]])->get();
        if($voteCard=$votedCards->last())
        $card=Card::where('id',$voteCard->card_id)->first(); // this is the card to be voted
        else
        $card =null;
        return view('participant.card',[
            'workshop'=>$workshop,
            'card'=>$card
        ]);
    }
    public function votecard(Workshop $workshop){ // added
        request()->validate([
            "score"=>'required|integer|min:1|max:5'
        ]);
        $workshop->voted++;
        $workshop->save();
        Auth::user()->can_vote=0;
        Auth::user()->save();
        $votedCards=Voting::where([['user_id',Auth::user()->id],['workshop_id',$workshop->id]])->get();
        $voteCard=$votedCards->last();
        $card=Card::where('id',$voteCard->card_id)->first();
        $card->score+=request('score');
        $card->save();
        if($workshop->voted==$workshop->participated){
            $monitor = User::find($workshop->user_id);
            $monitor->can_vote = 0;
            $monitor->save();
            if($votedCards->count()==5){
                //last user voting
                $workshop->finished=1;
                $workshop->save();
                return redirect(route('chooseproject',$workshop->id));
            }
        }

        return redirect(route('card',$workshop->id));
    }
    public function chooseproject(Workshop $workshop){ // added
        return view('participant.chooseproject');
    }
}
