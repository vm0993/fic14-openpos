<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsActivated
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next): Response
    {
        dd($request->user()->isActivated());
        if (($request->user()) && (!$request->user()->isActivated())) {
            Auth::logout();
            return redirect()->guest('login');
        }

        return $next($request);
    }
}
