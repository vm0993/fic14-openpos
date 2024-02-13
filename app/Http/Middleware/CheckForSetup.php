<?php

namespace App\Http\Middleware;

use App\Models\Sistem\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForSetup
{
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->is('_debugbar*')) {
            return $next($request);
        }

        if (Company::setupCompleted()) {
            if ($request->is('setup*')) {
                return redirect(config('app.url').'/dashboard');
            } else {
                return $next($request);
            }
        } else {
            if (! ($request->is('setup*')) && ! ($request->is('.env')) && ! ($request->is('health'))) {
                return redirect(config('app.url').'/setup');
            }

            return $next($request);
        }
    }
}
