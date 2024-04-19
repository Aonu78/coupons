<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ProjectLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = "jp";

        if ($request->header('Accept-Language') && in_array($request->header('Accept-Language'), ['en', 'jp'])) {
            $language = $request->header('Accept-Language');
        }

        try {
            if ($request->session()->has('locale')) {
                $language = session('locale');
            }
        } catch (\Exception $e) {}


        App::setLocale($language);

        return $next($request);
    }
}
