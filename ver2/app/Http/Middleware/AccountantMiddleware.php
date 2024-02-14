<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class AccountantMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {

		if(!\Auth::user())
		{
			return \Redirect::to('/')->with('error', 'You do not have a valid permission to access this resource');
		}

		if((\Auth::user()->role_code != \App\Models\Roles::$ACCOUNTANT))
		{
        	return response('Unauthorized.1', 401);
		}
		return $next($request);
    }
}
