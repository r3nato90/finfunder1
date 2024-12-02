<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (\Illuminate\Http\Response|RedirectResponse) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$this->alreadyInstalled()) {
            return redirect()->route('installer.index');
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled(): bool
    {
        return file_exists(storage_path('installed'));
    }
}
