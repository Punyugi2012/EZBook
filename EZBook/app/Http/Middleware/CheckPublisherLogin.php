<?php

namespace App\Http\Middleware;

use Closure;

class CheckPublisherLogin
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
        if(!session()->has('publisher')) {
            return redirect('/publisher-login');
        }
        return $next($request);
    }
}
