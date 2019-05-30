<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Route;


class ClearanceMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (auth('admin')->user()->hasPermissionTo('Administer roles & permissions'))
        {
            return $next($request);  // 管理员具备所有权限
        }
        $request_url = $request->path();
        $request_arr = explode('/',$request_url);
        $request_url = isset($request_arr[1])?$request_arr[0].'/'.$request_arr[1]:$request_arr[0];
        $permissions = Permission::where('name',$request_url)->get();

        if(!$permissions->isEmpty()){
            if (!auth('admin')->user()->hasPermissionTo($request_url))
            {
                abort('401');
            }
            else {
                return $next($request);
            }
        }else{
            abort('404');
        }

        return $next($request);
    }
}