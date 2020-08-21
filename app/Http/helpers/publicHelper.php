<?php
if (!function_exists('aurl')) {
    function aurl($url=null)
    {
        return url('admin/'.$url);
    }
}
if (!function_exists('adminAuth')) {
	function adminAuth()
	{
		return auth()->guard('admin');
	}
}
if (!function_exists('authInfo')) {
	function authInfo()
	{
		if (adminAuth()->check()) {
			$id = adminAuth()->user()->id;
			$userInfo = \App\Models\Admin::where('id',$id)->first();
			return $userInfo;
		}
	}
}
// page direction
if (!function_exists('dirPage')) {
	function dirPage()
	{
		if (session()->has('lang')) {
			if (session('lang')=='ar') {
				return 'rtl';
			}else{
				return 'ltr';
			}
		}
		else{
			return 'ltr';
		}
	}
}
// page language
if (!function_exists('lang')) {
	function lang()
	{
		if (session()->has('lang')) {
			return session('lang');
		}
		else{
			if (adminAuth()->check()) {
				session()->put('lang',authInfo()->preferredLanguage);
			}

			return session('lang');
		}
	}
}
if (!function_exists('settingHelper')) {
	function settingHelper()
	{
		return \App\Models\Setting::orderBy('id','desc')->first();
	}
}
if (!function_exists('history')) {
	function history($section,$crud,$history)
	{
        \App\Models\History::create([
            'section'   => $section,
            'history'   => $history,
            'crud'      => $crud,
            'user_id'   => auth()->id()
        ]);
	}
}
