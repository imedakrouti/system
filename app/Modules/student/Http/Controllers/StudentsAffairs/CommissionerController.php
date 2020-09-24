<?php
namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Student\Http\Requests\CommissionerRequest;
use Student\Models\Students\Commissioner;
use Student\Models\Students\Student;
use Student\Models\Students\StudentCommissioner;
use PDF;

class CommissionerController extends Controller
{
    public $file_name;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        if (request()->ajax()) {
            $data = Commissioner::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('commissioners.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('print', function($data){
                        $btn = '<a class="btn btn-info btn-sm" href="'.route('commissioners-students.print',$data->id).'">
                        <i class=" la la-print"></i> '.trans('student::local.print_commissioner_report').'
                        </a>';
                            return $btn;
                    })                    
                    ->addColumn('commissioner_name',function($data){
                        return '<a href="'.route('commissioners.show',$data->id).'">'.$data->commissioner_name.'</a>';
                    })
                    ->addColumn('file_name',function($data){
                        $file =  '<a target="blank" class="btn btn-success btn-sm" href="'.asset('storage/attachments/'.$data->file_name).'">
                                    <i class=" la la-download"></i>
                                </a>';
                        return empty($data->file_name) ? '' : $file;                                
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','file_name','commissioner_name','print'])
                    ->make(true);
        }
        return view('student::students-affairs.commissioners.index',
        ['title'=>trans('student::local.commissioners')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::students-affairs.commissioners.create',
        ['title'=>trans('student::local.new_commissioner')]);
    }
    private function attributes()
    {
        return [
            'commissioner_name',
            'id_number',      
            'mobile',      
            'notes',                    
            'relation'                
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommissionerRequest $request)
    {
        $this->uploadFileName($request->id);  

        $request->user()->commissioners()->create($request->only($this->attributes())+
        [ 'file_name' => $this->file_name]);        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('commissioners.index');
    }

    private function uploadFileName($commissionerId)
    {        
        if (request()->hasFile('file_name'))
        {
            if (!empty($commissionerId)) {
                $imageName = Commissioner::findOrFail($commissionerId)->file_name;
                Storage::delete('public/attachments/'.$imageName);                                                             
            }
            
            $imagePath = request()->file('file_name')->store('public/attachments');
            $imagePath = explode('/',$imagePath);
            $imagePath = $imagePath[2];     
                       
            $this->file_name = empty($imagePath)?'':$imagePath;
        } 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Commissioner  $commissioner
     * @return \Illuminate\Http\Response
     */
    public function show(Commissioner $commissioner)
    {
        if (request()->ajax()) {
            $data = StudentCommissioner::with('students')->where('commissioner_id',$commissioner->id)->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('check', function($data){
                        $btnCheck = '<label class="pos-rel">
                                     <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                     <span class="lbl"></span>
                                 </label>';
                         return $btnCheck;
                    })                                        
                    ->addColumn('student_number',function($data){
                        return $data->students->student_number;
                    })
                    ->addColumn('student_name',function($data){
                        return $this->studentName($data);
                    })
                    ->addColumn('grade',function($data){
                        return session('lang') == 'ar' ?$data->students->grade->ar_grade_name :$data->students->grade->en_grade_name;
                    })
                    ->addColumn('division',function($data){
                        return session('lang') == 'ar' ?$data->students->division->ar_division_name :$data->students->division->en_division_name;
                    })                                                            
                    ->rawColumns(['student_number','student_name','grade','division','check'])
                    ->make(true);
        }  
        $students = Student::with('father')->student()->orderBy('ar_student_name')->get();   
        $title    = trans('student::local.commissioner_profile');
        return view('student::students-affairs.commissioners.show',
        compact('commissioner','students','title'));
    }
    private function studentName($data)
    {
        return session('lang') == 'ar' ?
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->ar_student_name.' '. $data->students->father->ar_st_name .' '.$data->students->father->ar_nd_name .' '.$data->students->father->ar_rd_name .' '.$data->students->father->ar_th_name .'</a>':
        
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->en_student_name.' '.$data->students->father->en_st_name .' '.$data->students->father->en_nd_name .' '.$data->students->father->en_rd_name .' '.$data->students->father->en_th_name .'</a>';  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commissioner  $commissioner
     * @return \Illuminate\Http\Response
     */
    public function edit(Commissioner $commissioner)
    {
        return view('student::students-affairs.commissioners.edit',
        ['title'=>trans('student::local.commissioner_profile'),'commissioner'=>$commissioner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commissioner  $commissioner
     * @return \Illuminate\Http\Response
     */
    public function update(CommissionerRequest $request, Commissioner $commissioner)
    {
        $this->uploadFileName($request->id);  

        $commissioner->update($request->only($this->attributes())+
        [ 'file_name' => $this->file_name]);   
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('commissioners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commissioner  $commissioner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commissioner $commissioner)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Commissioner::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function storeStudents()
    {
        if (request()->ajax()) {
            request()->user()->studentsCommissioners()->firstOrCreate([
                'student_id' => request('student_id'),
                'commissioner_id' => request('commissioner_id'),
            ]);
        }
        return response(['status'=>true]);
    }
    public function destroyStudents()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    StudentCommissioner::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function printStudents($id)
    {   
        $commissioner = commissioner::with('students')->findOrFail($id);        
        $data = [        
            'commissioner'                  => $commissioner,       
            'title'                         => 'commissioner',       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => schoolName(),               
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
    
		$pdf = PDF::loadView('student::students-affairs.commissioners.report', $data,[],$config);
		return $pdf->stream('commissioner');
    }

    public function student($id)
    {
        $student = Student::findOrFail($id);
        $commissioners = Commissioner::with('students')
        ->whereHas('students',function($q) use ($id){
            $q->where('students.id',$id);
        })
        ->get();        
        $title = trans('student::local.commissioner_profiles');
        return view('student::students-affairs.commissioners.student',
        compact('title','commissioners','student'));
    }

    public function studentReport($id)
    {
        $student = Student::findOrFail($id);
        $commissioners = Commissioner::with('students')
        ->whereHas('students',function($q) use ($id){
            $q->where('students.id',$id);
        })
        ->get();       
        $data = [        
            'commissioners'                 => $commissioners,       
            'student'                       => $student,       
            'title'                         => 'commissioner',       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => schoolName(),               
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
    
		$pdf = PDF::loadView('student::students-affairs.commissioners.student-report', $data,[],$config);
		return $pdf->stream('commissioner');
    }
}
