<?php

namespace App\Http\Middleware;

use Closure;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->header('language');
            if($lang=="ar"){
                \App::setLocale('ar');
            }else{
                \App::setLocale('en');
            }
//        dd($lang);
        return $next($request);
    }
}
