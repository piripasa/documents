<?php

namespace App\Http\Middleware;

use Closure;

class AutoTrimmerMiddleware
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
        $request->merge(array_map(function($item){
            if(is_string($item)){
               return trim($item);
            }
            return $item;
        }, $request->all()));

        return $next($request);
    }
}
