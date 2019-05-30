<?php

namespace App\Http\Middleware;

use Closure;

class CheckAllowOrigin
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
          if(check_client_referer(true,'.sanye666.top')){
              return $next($request);
          }else{
              return false;
          }
    }
}
