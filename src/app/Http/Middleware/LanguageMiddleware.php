<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            DB::connection()->getPdo();
            session()->put('lang', $this->getCode());
            app()->setLocale(session('lang',  $this->getCode()));
            return $next($request);

        }catch (\Exception $exception){
            return $next($request);
        }
    }


    public function getCode()
    {
        if (session()->has('lang')) {
            return session('lang');
        }

        $language = Language::where('is_default', Status::ACTIVE->value)->first();
        return $language ? $language->code : 'en';
    }
}
