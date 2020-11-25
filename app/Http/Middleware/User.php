<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class User
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
        if (session('connection') == 'mysql') {            
            Config::set('database.default', 'mysql');            
        }else{              
            Config::set('database.default', 'mysql2');                        
        }
        if (empty($request->user())) {
            if (!empty(userAuthInfo())) {
                Auth::setUser(userAuthInfo());                
            }
        }
       
        if (!Auth::guard('web')->check()) {

            return redirect()->route('login');
        }
        return $next($request);
    }
}
