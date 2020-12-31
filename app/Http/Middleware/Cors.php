<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;
class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET,PUT,POST,PATCH,DELETE,OPTION')
            ->header('Access-Control-Allow-Headers', 'Accept,Content-Type,Authorization,Authorizations,XMLHttpRequest,X-Authorization,X-Request-With');
    }
}
