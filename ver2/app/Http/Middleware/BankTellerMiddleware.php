<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class BankTellerMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {

		if((\Auth::user()->role_code != \App\Models\Roles::$BANK_TELLER))
		{
        	return response('Unauthorized.', 401);
		}
		return $next($request);
    }
}
