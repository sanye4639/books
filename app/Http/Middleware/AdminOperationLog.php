<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work_Log;


class AdminOperationLog
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
        $admin_id = 0;
        if(Auth::check()) {
            $admin_id = (int) Auth::id();
        }
        $_SERVER['admin_uid'] = $admin_id;
        if('GET' != $request->method() && $admin_id != 0){
            $input = $request->all();
            Work_Log::create([
                'admin_id' => $admin_id,
                'path' => $request->path(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'sql' => '',
                'input' => json_encode($input, JSON_UNESCAPED_UNICODE)
            ]);
        }
        return $next($request);
    }
}
