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
		if (!empty($year)) {
			if ($year != null) {
				return $year->id;
			}else{
				return \Student\Models\Settings\Year::orderBy('id','desc')->first()->id;
			}			
		}	
	}
}

if (!function_exists('checkYearStatus')) {
	function checkYearStatus($year_id)
	{
		$year_status =  Student\Models\Settings\Year::findOrFail($year_id)->year_status;
		if ($year_status == trans('student::local.close')) {
			return true;
		}else{
			return false;
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
	function fullAcademicYear($yearId = null)
	{
		$year = '';
		if (empty($yearId)) {
			$year =  \Student\Models\Settings\Year::where('status','current')->first();				
		}else{
			$year =  \Student\Models\Settings\Year::where('id',$yearId)->first();				
		}
		
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
if (!function_exists('getStudentAgeByYear')) {
	function getStudentAgeByYear($year_id,$dob)
	{
		$dob_in = Student\Models\Settings\Year::findOrFail($year_id)->start_from;    		                 
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
		return public_path('images/website/'.settingHelper()->logo);   
	}
}

if (!function_exists('preamble')) {
	function preamble()
	{	
		$data = [];
		if (session('lang') == 'ar') {
			$data['school_name'] 				= settingHelper()->ar_school_name;
			$data['education_administration'] 	= settingHelper()->ar_education_administration;
			$data['governorate'] 				= settingHelper()->ar_governorate;
		}else{
			$data['school_name'] 				= settingHelper()->en_school_name;
			$data['education_administration'] 	= settingHelper()->en_education_administration;
			$data['governorate'] 				= settingHelper()->en_governorate;
		}	
		return $data;
	}
}
/**
 * get school name by division
 */
if (!function_exists('getSchoolName')) {
	function getSchoolName($division_id)
	{		
		// get school name
        $division = Student\Models\Settings\Division::findOrFail($division_id);
        return session('lang') == 'ar' ? $division->ar_school_name : $division->en_school_name;		
	}
}

/**
 * uploading
 * 
 * $image_path : current file to remove
 * $image_name : request('file_name') like request('logo')
 * $store_at : destination directory to store
 */
if (!function_exists('uploadFileOrImage')) {
	function uploadFileOrImage($image_path,$image_name, $store_at)
	{		
		// remove old image  
		if(\File::exists($image_path)) {
			\File::delete($image_path);                
		}  
		// upload image
		$file_extension = $image_name->getClientOriginalExtension();
		$file_name = time().'.'.$file_extension;
		$path = $store_at;
		$image_name->move($path,$file_name); 
		return $file_name;  
	}
}

if (!function_exists('removeFileOrImage')) {
	function removeFileOrImage($image_path)
	{		
		// remove old image  
		if(\File::exists($image_path)) {
			\File::delete($image_path);                
		}   
	}
}

if (!function_exists('getClassroomName')) {
	function getClassroomName($classroom_id)
	{				
		$classroom = Student\Models\Settings\Classroom::findOrFail($classroom_id);  
		$className = session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom ;     
		return $className;   	
	}
}

