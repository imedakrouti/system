<?php

namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;

use Student\Models\Admissions\AdmissionReport;
use PDF;
use Student\Http\Requests\AdmissionReportRequest;
use Student\Models\Parents\Father;
use Student\Models\Parents\Mother;

class ParentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = AdmissionReport::with('fathers','admin')->Parents()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('report_title',function($data){
                        return '<a href="'.route('parent-reports.show',$data->id).'">'.$data->report_title.'</a>' ;
                    })
                    ->addColumn('father_name',function($data){
                        return $this->getFatherName($data);
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
                    ->rawColumns(['father_name','check','created_by','report_title'])
                    ->make(true);
        }
        $title = trans('student::local.parent_reports');        
        
        return view('student::admissions.parents-reports.index',compact('title'));
    }

    private function getFatherName($data)
    {
        return session('lang') == 'ar' ?
        '<a href="'.route('father.show',$data->fathers->id).'">'.$data->fathers->ar_st_name .' '.$data->fathers->ar_nd_name .' '.$data->fathers->ar_rd_name .' '.$data->fathers->ar_th_name .'</a>':
        
        '<a href="'.route('father.show',$data->fathers->id).'">'.$data->fathers->en_st_name .' '.$data->fathers->en_nd_name .' '.$data->fathers->en_rd_name .' '.$data->fathers->en_th_name .'</a>';  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('student::local.add_parent_report');
        $fathers = Father::all();

        return view('student::admissions.parents-reports.create',
        compact('title','fathers'));
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
        foreach ($request->father_id as $father) {
            $request->user()->reports()->create($request->only($this->attributes()) + ['father_id' => $father]);                    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('parent-reports.index');
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fatherId = AdmissionReport::findOrFail($id)->father_id;
        $mothers = Mother::with('fathers','students')
        ->whereHas('fathers',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->whereHas('students',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->get();
        // dd($mothers);
        $title = trans('student::local.show_parent_report');
        $report = AdmissionReport::with('fathers')->findOrFail($id);


        return view('student::admissions.parents-reports.show',
        compact('title','report','mothers'));
    }
    public function edit($id)
    {
        $fathers = Father::all();
        $title = trans('student::local.edit_parent_report');
        $report = AdmissionReport::with('fathers')->findOrFail($id);

        return view('student::admissions.parents-reports.edit',
        compact('title','report','fathers'));
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
        + ['father_id' => $request->father_id]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('parent-reports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdmissionReport  $admissionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy()
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
    public function parentReportPdf($id)
    {                      

        $fatherId = AdmissionReport::findOrFail($id)->father_id;

        $reports = AdmissionReport::with('admin','fathers')->findOrFail($id);

        $mothers = Mother::with('fathers','students')
        ->whereHas('fathers',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->whereHas('students',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })
        ->get();


        $data = [        
            'reports'                       => $reports,                   
            'mothers'                       => $mothers,                   
            'title'                         => 'Parent Report',       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => '',               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
            ];
        $config = [            
            'margin_header'        => 5,
            'margin_footer'        => 10,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,
            'margin_bottom'        => 0,
        ];  

        $pdf = PDF::loadView('student::admissions.parents-reports.pdf-report', $data,[],$config);
		return $pdf->stream('Parent Report');
    }
    public function fatherReport($fatherId)
    {
        $father = Father::findOrFail($fatherId);
        $title = trans('student::local.parent_reports');
        $reports =  AdmissionReport::with('fathers','admin')->whereHas('fathers',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })->get();

        return view('student::admissions.parents-reports.father-report',
        compact('father','title','reports'));
    }
}
