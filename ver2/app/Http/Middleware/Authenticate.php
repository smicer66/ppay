<?php
/*
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
*/


namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    protected $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {

       //dd(\Auth::user());
	   //die($request->ajax());
	   //dd($this->auth->guest());
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        //dd([$this->auth, \Auth::user()]);
        return $next($request);
    }
}
