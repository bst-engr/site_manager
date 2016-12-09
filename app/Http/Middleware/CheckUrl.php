<?php

namespace App\Http\Middleware;

use Closure;

class CheckUrl
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
         
        if($request->page ==2)
         return $next($request);
        else
        return redirect('portal');

    }
}
