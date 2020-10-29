<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class ClosureController extends Controller
{
    public function index()
    {
        return redirect('/admin');
    }

    public function lang($lang)
    {
        // check session lang and destroy session
        $data['lang'] = $lang;

        if (adminAuth()->check()) {
            \App\Models\Admin::where('id',authInfo()->id)->update($data);
        }

        session()->has('lang')?session()->forget('lang'):'';
        // set new session
        $lang == 'ar' || $lang == trans('admin.ar') ? session()->put('lang','ar'):session()->put('lang','en');
        //return to previous page
        return back();
    }

    public function checkLogin()
    {
        if (session()->has('login')) {
            if (adminAuth()->check()) {
                return redirect('/dashboard');                
            }
            else{
                return redirect('/login');                
            }
        }
        else{
            return redirect('/login');            
        }
    }
}
