<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, $section = null)
    {
        if (Gate::allows($section)) {
            return $next($request);
        }

        return response()->view('template.app', [
            'content' => view('errors/403'),
        ]);
    }
}
