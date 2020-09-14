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
            'admin_id'   => auth()->id()
        ]);
	}
}
if (!function_exists('currentYear')) {
	function currentYear()
	{
		$year =  \Student\Models\Settings\Year::where('status','current')->first();		
		if ($year != null) {
			return $year->id;
		}else{
			return \Student\Models\Settings\Year::orderBy('id','desc')->first()->id;
		}
	}
}
if (!function_exists('getYearAcademic')) {
	function getYearAcademic()
	{
		$year =  \Student\Models\Settings\Year::where('status','current')->first();	
		
		if ($year != null) {
			$date = \DateTime::createFromFormat("Y-m-d",$year->start_from);
			return $date->format("y");			
		}
		return '0000';
	}
}
if (!function_exists('fullAcademicYear')) {
	function fullAcademicYear()
	{
		$year =  \Student\Models\Settings\Year::where('status','current')->first();	
		
		if ($year != null) {
			$date = \DateTime::createFromFormat("Y-m-d",$year->start_from);
			return $year->name;		
		}
		return 'none';
	}
}

// calculate student age
if (!function_exists('getStudentAge')) {
	function getStudentAge($dob)
	{
        $dob_in = Student\Models\Settings\Year::current()->first()->start_from;                        
		$dobObject = new \DateTime($dob);		
		$now = new \Carbon\Carbon($dob_in);
		$thisYear   = $now->year;
		$nowObject = Carbon\Carbon::create( $thisYear,10, 1 , 0, 0, 0);
		$diff = $dobObject->diff($nowObject);
		$data['dd'] = $diff->d;
		$data['mm'] = $diff->m;
		$data['yy'] = $diff->y;

		return $data;
	}
}

if (!function_exists('schoolName')) {
	function schoolName()
	{
		return session('lang') == 'ar'?settingHelper()->ar_school_name:settingHelper()->en_school_name;
	}
}

if (!function_exists('logo')) {
	function logo()
	{
		return public_path('storage/logo/'.settingHelper()->logo);   
	}
}