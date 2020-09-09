<?php

namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;

use Student\Models\Admissions\AdmissionReport;
use PDF;
use Student\Http\Requests\AdmissionReportRequest;
use Student\Models\Parents\Mother;
use Student\Models\Students\Student;

class StudentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = AdmissionReport::with('students','admin')->Students()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('report_title',function($data){
                        return '<a href="'.route('student-reports.show',$data->id).'">'.$data->report_title.'</a>' ;
                    })
                    ->addColumn('student_name',function($data){
                        return $this->getStudentName($data);
                    })
                    ->addColumn('created_by',function($data){
                        return $data->admin->name;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['student_name','check','created_by','report_title'])
                    ->make(true);
        }
        $title = trans('student::local.student_reports');        
        
        return view('student::admissions.students-reports.index',compact('title'));        
    }
    private function getStudentName($data)
    {        
        return session('lang') == trans('admin.ar') ?
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->ar_student_name.' '. $data->students->father->ar_st_name .' '.$data->students->father->ar_nd_name .' '.$data->students->father->ar_rd_name .' '.$data->students->father->ar_th_name .'</a>':
        
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->en_student_name.' '.$data->students->father->en_st_name .' '.$data->students->father->en_nd_name .' '.$data->students->father->en_rd_name .' '.$data->students->father->en_th_name .'</a>';  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('student::local.add_student_report');
        $students = Student::with('father')->get();

        return view('student::admissions.students-reports.create',
        compact('title','students'));
    }
    private function attributes()
    {
        return [            
            'report_title',
            'report',
            'notes',            
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionReportRequest  $request)
    {
        foreach ($request->student_id as $student) {
            $request->user()->reports()->create($request->only($this->attributes()) + ['student_id' => $student]);                    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('student-reports.index');
    }

    public function show($id)
    {
        $studentId = AdmissionReport::findOrFail($id)->student_id;
        $fatherId = Student::findOrFail($studentId)->father_id;
        
        $mothers = Mother::with('fathers','students')
        ->whereHas('fathers',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->whereHas('students',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->get();

        $title = trans('student::local.show_parent_report');
        $report = AdmissionReport::with('fathers','students')->findOrFail($id);
        
        // dd($report);

        return view('student::admissions.students-reports.show',
        compact('title','report','mothers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $students = Student::with('father')->get();
        $title = trans('student::local.edit_parent_report');
        $report = AdmissionReport::with('fathers')->findOrFail($id);

        return view('student::admissions.students-reports.edit',
        compact('title','report','students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionReportRequest $request, $id)
    {
        $report = AdmissionReport::findOrFail($id);
        $report->update($request->only($this->attributes())
        + ['student_id' => $request->student_id]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('student-reports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdmissionReport $admissionReport)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    AdmissionReport::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function studentReportPdf($id)
    {              
        $fileBladePath = 'student::admissions.students-reports.pdf-report';   

        $studentId = AdmissionReport::findOrFail($id)->student_id;
        $fatherId = Student::findOrFail($studentId)->father_id;

        $data['report'] = AdmissionReport::with('admin','fathers','students')->findOrFail($id);

        $data['mothers'] = Mother::with('fathers','students')
        ->whereHas('fathers',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->whereHas('students',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->get();
        $data['title'] = 'Student Report';        
        $filename = 'student-report.pdf';

        $pdf = PDF::loadView('student::admissions.students-reports.pdf-report', $data);
		return $pdf->stream( $filename);
    }
    public function studentReport($studentId)
    {        
        $student = Student::findOrFail($studentId);
        $title = trans('student::local.student_reports');
        $reports =  AdmissionReport::with('students','admin')->whereHas('students',function($q) use ($studentId){
            $q->where('student_id',$studentId);
        })->get();


        return view('student::admissions.students-reports.student-report',
        compact('student','title','reports'));
    }    
}
