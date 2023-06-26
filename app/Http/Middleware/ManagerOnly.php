<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
class ManagerOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->user() || (auth()->user() && auth()->user()->status!='active'))
        { 
            Session::flush();
            Auth::logout();
            return redirect()->route('home');   
        }
        else if(auth()->user() && ( auth()->user()->access=='hotel_staff' || auth()->user()->access=='customer') ) 
        {
            return redirect()->route('home');  
        }
        return $next($request);
    }
}
