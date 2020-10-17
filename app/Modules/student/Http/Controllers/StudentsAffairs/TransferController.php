<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Http\Requests\TransferRequest;
use Illuminate\Http\Request;
use Student\Models\Settings\Grade;
use Student\Models\Settings\School;
use Student\Models\Settings\Year;
use Student\Models\Students\SetMigration;
use Student\Models\Students\Student;
use Student\Models\Students\Transfer;
use PDF;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Transfer::with('students','currentGrade','nextGrade','currentYear','nextYear','schools')
            ->orderBy('id','desc')->get();

            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('transfers.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('print', function($data){
                        $btn = '<a class="btn btn-primary btn-sm" target="_blank" href="'.route('transfers.print',$data->id).'">
                            '.trans('student::local.print').'
                        </a>';
                            return $btn;
                    })                    
                    ->addColumn('student_number',function($data){
                        return $data->students->student_number;
                    })
                    ->addColumn('student_name',function($data){
                        return $this->getStudentName($data);
                    })
                    ->addColumn('grade',function($data){
                        return session('lang') == 'ar' ? $data->students->grade->ar_grade_name:$data->students->grade->en_grade_name;
                    })  
                    ->addColumn('year',function($data){
                        return $data->currentYear->name;
                    })     
                    ->addColumn('school_name',function($data){
                        return $data->schools->school_name;
                    })                                                                             
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','student_number','student_name','grade','year','school_name','print'])
                    ->make(true);
        }
        return view('student::students-affairs.transfers.index',
        ['title'=>trans('student::local.transfers')]);  
    }
    private function getStudentName($data)
    {        
        return session('lang') == 'ar' ?
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
        $grades = Grade::sort()->get();
        $years = Year::open()->orderBy('id','desc')->where('status','<>','current')->get();
        $schools = School::orderBy('id','desc')->get();
        $students = Student::with('father')->whereDoesntHave('transfers')
        ->orderBy('ar_student_name')->get();
        $title = trans('student::local.new_transfer');

        return view('student::students-affairs.transfers.create',
        compact('grades','years','schools','students','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function attributes()
    {
        return  [
            'leaved_date',
            'leave_reason',
            'school_fees',
            'school_books',
            'school_id',            
            'student_id'   
        ];
    }
    public function store(TransferRequest $request)
    {
        $current_grade_id = Student::findOrFail(request('student_id'))->grade_id;

        $next_grade_id = SetMigration::where('from_grade_id',$current_grade_id)->first()->to_grade_id;
        $request->user()->transfers()->create($request->only($this->attributes())+
        [
            'current_grade_id'  => $current_grade_id,
            'next_grade_id'     => $next_grade_id,
            'current_year_id'   => currentYear(),
            'next_year_id'      => request('year_id')
            ]);        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('transfers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        $grades = Grade::sort()->get();
        $years = Year::open()->orderBy('id','desc')->where('status','<>','current')->get();
        $schools = School::orderBy('id','desc')->get();
        $students = Student::with('father')->whereHas('transfers')
        ->orderBy('ar_student_name')->get();
        $title = trans('student::local.edit_transfer');

        return view('student::students-affairs.transfers.edit',
        compact('grades','years','schools','students','title','transfer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(TransferRequest $request, Transfer $transfer)
    {
        $current_grade_id = Student::findOrFail(request('student_id'))->grade_id;

        $next_grade_id = SetMigration::where('from_grade_id',$current_grade_id)->first()->to_grade_id;

        $transfer->update($request->only($this->attributes())+
        [
            'current_grade_id'  => $current_grade_id,
            'next_grade_id'     => $next_grade_id,
            'current_year_id'   => currentYear(),
            'next_year_id'      => request('year_id')
            ]); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('transfers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Transfer::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function printTransferReport($id)
    {
        $transfer = Transfer::with('students','currentGrade','nextGrade','currentYear','nextYear','schools')
        ->findOrFail($id);

        $data = [  
            'transfer'                      => $transfer,       
            'title'                         => 'Transfer Report',                   
            'logo'                          => logo(),            
            'school_name'                   => getSchoolName($transfer->students->division_id),               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 2,
            'margin_footer'        => 50,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 32,
            'margin_bottom'        => 5,
        ]; 

        $pdf = PDF::loadView('student::students-affairs.transfers.reports.student-transfer', $data,[],$config);
        return $pdf->stream('Transfer Report');
    }
    public function emptyTransferReport()
    {        
        $data = [  
            
            'title'                         => 'Transfer Report',                   
            'logo'                          => logo(),                        
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 2,
            'margin_footer'        => 50,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 32,
            'margin_bottom'        => 5,
        ]; 

        $pdf = PDF::loadView('student::students-affairs.transfers.reports.empty-student-transfer', $data,[],$config);
        return $pdf->stream('Transfer Report');        
    }
}
