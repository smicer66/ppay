<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class WalletUserMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
		
		if(\Auth::user() && (\Auth::user()->role_code == \App\Models\Roles::$CUSTOMER))
		{
            return $next($request);
		}


        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        return redirect()->guest('auth/login');

    }
}
