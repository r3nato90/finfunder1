<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_MODE') == 'demo'){
            if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')){
                return back()->with('notify', [['error', "This is a demo version. You cannot change anything."]]);
            }
        }

        return $next($request);
    }
}
