<?php
if (!function_exists('userAuth')) {
	function userAuth()
	{
		return auth()->guard('web');
	}
}

if (!function_exists('userAuthInfo')) {
	function userAuthInfo()
	{
		if (userAuth()->check()) {
            $id = userAuth()->user()->id;            
			$userInfo = \App\Models\User::with('studentUser')->where('id',$id)->first();   			
			return $userInfo;
		}
	}
}

if (!function_exists('student_id')) {
	function student_id()
	{				        
		return userAuthInfo()->studentUser->id; 	
	}
}

if (!function_exists('division_id')) {
	function division_id()
	{				        
		return userAuthInfo()->studentUser->division->id; 	
	}
}

if (!function_exists('grade_id')) {
	function grade_id()
	{				        
		return userAuthInfo()->studentUser->grade->id; 	
	}
}

if (!function_exists('studentSubjects')) {
	function studentSubjects()
	{				        
		return userAuthInfo()->studentUser->subjects; 	
	}
}

if (!function_exists('classroom_id')) {
	function classroom_id($student = null)
	{			
		$classroom_id = '';			
		if (empty($student)) {
			$student = userAuthInfo()->studentUser;
		}else{
			$student = $student;
		}
        foreach ($student->rooms as $classroom) {
            if ($classroom->year_id == currentYear()) {
                $classroom_id = $classroom->classroom_id;
            }
		}	   
	
		return $classroom_id; 	
	}
}

if (!function_exists('evaluation')) {
	function evaluation($total_mark, $mark)
	{	
		if ($mark != 0) {
			$percentage = ($mark / $total_mark) * 100;
			
			switch ($percentage) {
				case $percentage >= 95  : return 'A+';
				case $percentage >= 85 && $percentage < 95  : return 'A';
				case $percentage >= 75 && $percentage < 85  : return 'B';
				case $percentage >= 65 && $percentage < 75  : return 'C';
				case $percentage < 65  : return 'D';			
			}			
		}
		return 'D';		
	}
}