<?php

namespace App\Http\Controllers\ParentStudent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;


use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function login()
    {   
        if (session()->has('login') == true) {  
            if (userAuth()->check()) {
                if (userAuthInfo()->domain_role == 'student') {
                    return redirect()->route('student.dashboard');              
                }else{
                  return redirect()->route('parent.dashboard');              
                }                            
            }else{
                return redirect()->route('admin.login');
            }           
        }else{
            return view('layouts.front-end.user.login');
        }
    }

    public function setLogin(LoginRequest $request)
    {  
        Config::set('auth.defaults.guard','web');      
        $rememberMe = $request->input('rememberMe')==1 ?true:false;
        
        if (request('school') == 'mysql') {            
            Config::set('database.default', 'mysql');            
        }else{              
            Config::set('database.default', 'mysql2');                        
        }
            
        
        if (userAuth()->attempt(request(['username','password'],$rememberMe)))
        {                 
            if (userAuthInfo()->status == trans('admin.inactive')) {
                return redirect()->route('login')->with('error',trans('admin.inactive_account'));
            }
            session()->put('login',true);

            if (!session()->has('lang')) {
                if (userAuthInfo()->lang == trans('admin.ar')) {
                    session()->put('lang','ar');                    
                }else{
                    session()->put('lang','en');                    
                }
            }
            if (request('school') == 'mysql') {
                session()->put('connection','mysql');                                    
            }else{
                session()->put('connection','mysql2');                                    
            }         
            
        }

        return redirect()->route('login')->with('error',trans('admin.invalid_login'));
    }

    public function logout()
    {
        userAuth()->logout();
        session()->forget('login');
        session()->forget('connection');
        
        if (!session()->has('lang')) {
            session()->put('lang',userAuthInfo()->lang);
        }
        
        // session()->forget('lang');
        alert()->success(trans('msg.log_out'), trans('msg.good_bye'));
    	return redirect()->route('login');
    }


    
}
