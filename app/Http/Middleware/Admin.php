<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Admin
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
            if (!empty(authInfo())) {
                Auth::setUser(authInfo());                
            }
        }
       
        if (!Auth::guard('admin')->check()) {

            return redirect('admin/login');
        }
        return $next($request);
    }
}
