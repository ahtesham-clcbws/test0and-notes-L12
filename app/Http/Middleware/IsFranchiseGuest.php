<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Support\Facades\Auth;

class IsFranchiseGuest
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
        if(Auth::check()){
            return redirect()->route('franchise.dashboard');
        }
        Auth::logout();
        return $next($request);
    }
}