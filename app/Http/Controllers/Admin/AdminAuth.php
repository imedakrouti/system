<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminAuth extends Controller
{
    public function login()
    {
        if (session()->has('login') == true) {
            return view('layouts.cpanel');
        }else{
            return view('admin.auth.login');
        }
    }

    public function setLogin(LoginRequest $request)
    {
        $rememberMe = $request->input('rememberMe')==1 ?true:false;

        if (adminAuth()->attempt(['username'=>$request->input('username'),'password'=>$request->input('password')],$rememberMe))
        {
            if (authInfo()->status == trans('admin.inactive')) {
                return redirect(aurl('login'))->with('error',trans('admin.inactive_account'));
            }
            session()->put('login',true);

            if (!session()->has('lang')) {
                session()->put('lang',authInfo()->lang);
            }
            return redirect(aurl('dashboard'));
        }

        return redirect(aurl('login'))->with('error',trans('admin.invalid_login'));
    }

    public function logout()
    {
    	adminAuth()->logout();
        session()->forget('login');
        alert()->success(trans('msg.log_out'), trans('msg.good_bye'));
    	return redirect(aurl('login'));
    }

    public function changePassword()
    {
        $admin = Admin::find(authInfo()->id);
        return view('admin.auth.changePassword',['title'=>trans('admin.change_password'),'admin'=>$admin]);
    }

    private function passwordRules()
    {
        return [
            // rules
            'password'              => 'required',
            'cPassword'             => 'required|same:password',
        ];
    }

    private function msgPasswordRules()
    {
        return [
            // message
            'password.required'      => trans('msg.password_required'),
            'cPassword.required'     => trans('msg.confirm_password_required'),
            'cPassword.same'         => trans('msg.match_password'),
        ];
    }

    public function updateChangePassword()
    {
        // validation
        $this->validate(request(),$this->passwordRules(),$this->msgPasswordRules());
        // save data
        $admin = Admin::findOrFail(authInfo()->id);
        $admin->password   = request('password');
        $admin->save();

        alert()->success('', trans('msg.updated_password'));
        return back();
    }
}
