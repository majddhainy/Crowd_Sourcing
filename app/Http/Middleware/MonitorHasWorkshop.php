<?php

namespace App\Http\Middleware;

use Closure;
use App\Workshop;
use App\Card;
use Illuminate\Support\Facades\Auth;

class MonitorHasWorkshop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id=$request->route('workshop');
        $workshop=Workshop::find($id)->first();
        
        if($workshop==null || Auth::user()!=$workshop->user){
            return redirect(route('home'))->with('message','Are You Playing ?');
        }
        
        // if($workshop->locked==1 && $workshop->can_submit==1)
        //     return redirect(route('takecards',$id));
        // if($workshop->locked==0)
        //     return redirect(route('monitorworkshop',$id));
        return $next($request);
    }
}
