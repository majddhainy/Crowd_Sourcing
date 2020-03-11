<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workshop;
use App\Card;
use App\Voting;
use App\User;
use App\Project;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function __construct(){
        $this->middleware('participantplus')->only(['createcard','storecard','card','votecard','group']);
    }
    public function joinworkshop(){
        return view('participant.joinworkshop');
    }
    public function applytoworkshop(){ 
        // TODO WE MUST DENY HIM FROM PARTICIPATING TWICE TO THE SAME WORKSHOP

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
        event(new \App\Events\MyEvent(Auth::user()->name.' joined your workshop','monitor'.$workshop->id));
        if($workshop->participated==$workshop->participants)
            event(new \App\Events\MyEvent('Workshop is full','monitor'.$workshop->id));
        return redirect(route('createcard',$workshop->id));
    }
    public function createcard(Workshop $workshop){ 
        return view('participant.createcard',['workshop'=>$workshop]);
    }
    public function storecard(Workshop $workshop){ 
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
        if($workshop->participated==$workshop->voted) //inform monitor that all had submitted cards
            event(new \App\Events\MyEvent('All participants submitted their cards','monitor'.$workshop->id));
        Auth::user()->can_submit = 0;
        Auth::user()->save();
        return redirect(route('card' , $workshop->id));
    }
    public function card(Workshop $workshop){
        if($workshop->finished==1) // this case is when the rest of participants reloads the page AND after the last participant voted for the fifth time
            return redirect(route('group',$workshop->id));
        $votedCards=Voting::where([['user_id',Auth::user()->id],['workshop_id',$workshop->id]])->get();
        if($voteCard=$votedCards->last())
            $card=Card::where('id',$voteCard->card_id)->first(); // this is the card to be voted
        else
            $card =null;
        return view('participant.card',[
            'workshop'=>$workshop,
            'card'=>$card,
            'monitor'=>$workshop->user
        ]);
    }
    public function votecard(Workshop $workshop){
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
            // inform montior that all had voted on their cards
            event(new \App\Events\MyEvent('All participants voted their cards','monitor'.$workshop->id));
            if($votedCards->count()==5){
                //last user voting
                $workshop->finished=1;
                $workshop->save();
                //now inform all participants that workshop is finished and wait for distributing projects
                event(new \App\Events\MyEvent('Workshop finished, please wait untill getting your project','participants'.$workshop->id));
                return redirect(route('group',$workshop->id)); 
            }
        }
        return redirect(route('card',$workshop->id));
    }
    public function group(Workshop $workshop){
        $project=Project::where([['workshop_id',$workshop->id],['user_id',Auth::user()->id]])->first();
        $card=null;
        $members=null;
        if($project){
            $card=Card::where('id',$project->card_id)->first();
            $members=$card->members;
            $members=$members->keyBy('id');
            $members->forget(Auth::user()->id);
        }
        return view('participant.group',[
            'members'=>$members,
            'card'=>$card
        ]);
    }
}
