<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminGuest
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
            return redirect()->route('administrator.dashboard');
        }
        Auth::logout();
        return $next($request);
    }
}