<?php
namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;
use PDF;
use Student\Models\Settings\Language;
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
        $languages = Language::study()->sort()->get();        
        $languagesCount = Language::study()->count();        
        $grades = Grade::sort()->get();

        $students = [];

        foreach ($grades as $grade) {
            $where = [                
                ['division_id',request('division_id')],
                ['grade_id',$grade->id],
            ]; 

            foreach ($languages as $lang) {
                $students[] = [                    
                    'count' => Student::with('languages','statements','grade')
                                    ->whereHas('statements',function($q){
                                        $q->where('year_id',currentYear());
                                    })
                                    ->where($where)
                                    ->where('second_lang_id',$lang->id)
                                    ->count(),
                    'grade' => $grade->id
                ];
                
            }

          
        }        
        foreach ($languages as $lang) {
            $counting[] = [                    
                'count' => Student::with('languages','statements','grade')
                                ->whereHas('statements',function($q){
                                    $q->where('year_id',currentYear());
                                })                                    
                                ->where('division_id',request('division_id'))
                                ->where('second_lang_id',$lang->id)
                                ->count(),
                'lang' => $lang->id
            ];
            
        }  
     

        $data = [         
            'title'                         => 'Statistics Report',       
            'counting'                      => $counting,                   
            'languages'                     => $languages,                   
            'languagesCount'                => $languagesCount,                   
            'grades'                        => $grades,                   
            'students'                      => $students,       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => getSchoolName(request('division_id')),               
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
}
