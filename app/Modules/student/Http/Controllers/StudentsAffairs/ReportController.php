<?php
namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;
use PDF;
use Student\Models\Settings\Language;
use Student\Models\Settings\RegistrationStatus;
use Student\Models\Students\Student;

class ReportController extends Controller
{
    public function statistics()
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.statistics_reports');
        return view('student::students-affairs.reports.statistics',
        compact('title','grades','years','divisions'));
    }

    public function secondLangReportStatistics()
    {
        if (empty(request('division_id')) || empty(request('year_id'))) {
            toast(trans('student::local.no_division_selected'),'error');  
            return back();
        }

        $languages = Language::study()->sort()->get();        
        $languagesCount = Language::study()->count();        
        $grades = Grade::sort()->get();

        $students = [];

        foreach ($grades as $grade) {
            $where = [                                
                ['grade_id',$grade->id],
            ]; 

            foreach ($languages as $lang) {
                $students[] = [                    
                    'count' => Student::with('languages','statements','grade')
                                    ->whereHas('statements',function($q){
                                        $q->where('year_id',request('year_id'));
                                    })
                                    ->where($where)
                                    ->where('second_lang_id',$lang->id)
                                    ->whereIn('division_id',request('division_id'))
                                    ->count(),
                    'grade' => $grade->id
                ];
                
            }

          
        }        
        foreach ($languages as $lang) {
            $counting[] = [                    
                'count' => Student::with('languages','statements','grade')
                                ->whereHas('statements',function($q){
                                    $q->where('year_id',request('year_id'));
                                })                                    
                                ->whereIn('division_id',request('division_id'))
                                ->where('second_lang_id',$lang->id)
                                ->count(),
                'lang' => $lang->id
            ];
            
        }  
        
        $divisions = request('division_id');

        $school_name = count(request('division_id')) == 1 ? getSchoolName($divisions[0]) : '';
        
        $data = [         
            'title'                         => 'Statistics Report',       
            'counting'                      => $counting,                   
            'languages'                     => $languages,                   
            'languagesCount'                => $languagesCount,                   
            'grades'                        => $grades,                   
            'students'                      => $students,       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => $school_name,               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
        ];

        $config = [            
            'margin_header'        => 5,
            'margin_footer'        => 50,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,
            'margin_bottom'        => session('lang') == 'ar' ? 52 : 55,
        ];  

		$pdf = PDF::loadView('student::students-affairs.reports.statistics.second-lang', $data,[],$config);
		return $pdf->stream('Statistics');
    }

    public function regStatusReportStatistics()
    {
        if (empty(request('division_id')) || empty(request('year_id'))) {
            toast(trans('student::local.no_division_selected'),'error');  
            return back();
        }

        $regStatus = RegistrationStatus::sort()->get();        
        $regStatusCount = RegistrationStatus::count();        
        $grades = Grade::sort()->get();

        $students = [];

        foreach ($grades as $grade) {
            $where = [                                
                ['grade_id',$grade->id],
            ]; 

            foreach ($regStatus as $reg) {
                $students[] = [                    
                    'count' => Student::with('registration_status','grade')         
                                    ->where($where)
                                    ->where('registration_status_id',$reg->id)
                                    ->whereIn('division_id',request('division_id'))
                                    ->count(),
                    'grade' => $grade->id
                ];
                
            }

          
        }        
        foreach ($regStatus as $reg) {
            $counting[] = [                    
                'count' => Student::with('registration_status','grade')                                 
                                ->whereIn('division_id',request('division_id'))
                                ->where('registration_status_id',$reg->id)
                                ->count(),
                'regStatus' => $reg->id
            ];
            
        }  
        
        $divisions = request('division_id');

        $school_name = count(request('division_id')) == 1 ? getSchoolName($divisions[0]) : '';
        
        $data = [         
            'title'                         => 'Statistics Report',       
            'counting'                      => $counting,                   
            'regStatus'                     => $regStatus,                   
            'regStatusCount'                => $regStatusCount,                   
            'grades'                        => $grades,                   
            'students'                      => $students,       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => $school_name,               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
        ];

        $config = [            
            'margin_header'        => 5,
            'margin_footer'        => 50,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,
            'margin_bottom'        => session('lang') == 'ar' ? 52 : 55,
        ];  

		$pdf = PDF::loadView('student::students-affairs.reports.statistics.reg-status', $data,[],$config);
		return $pdf->stream('Statistics');
    }    
}
