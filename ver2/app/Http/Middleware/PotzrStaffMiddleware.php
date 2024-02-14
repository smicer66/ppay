<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class PotzrStaffMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
      //dd(\Auth::user());
	if(!(\Auth::user() && \Auth::user()!=null && \Auth::user()->role_code==\App\Models\Roles::$POTZR_STAFF))
	{
		//return response('Unauthorized.', 401);
		return \Redirect::to('/auth/login')->with('message', 'Session expired');

	}
      	//if((\Auth::user()->role_code != \App\Models\Roles::$POTZR_STAFF))
      //{
           // return response('Unauthorized.', 401);
     // }
	return $next($request);
      
    }
}
