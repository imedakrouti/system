<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Student\Models\Settings\Classroom;
use Illuminate\Http\Request;
use Student\Http\Requests\ClassroomRequest;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.classrooms');
        $data = Classroom::with('grade','division','year')->sort()->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('student::settings.classrooms.index',
        compact('grades','years','divisions','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.new_classroom');
        return view('student::settings.classrooms.create',
        compact('grades','years','divisions','title'));
    }

    private function attributes()
    {
        return [            
            'ar_name_classroom',
            'en_name_classroom',
            'division_id',   
            'grade_id',   
            'year_id', 
            'total_students',              
            'sort', 
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassroomRequest $request)
    {
        $request->user()->classrooms()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('classrooms.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classrooms  $Classrooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.edit_classroom');
        return view('student::settings.classrooms.edit',
        compact('grades','years','divisions','title','classroom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classroom  $Classrooms
     * @return \Illuminate\Http\Response
     */
    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        $classroom->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $Classrooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $Classrooms)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Classroom::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function filter()
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.classrooms');
        $data = Classroom::with('grade','division','year')->sort()
        ->where('grade_id',request('grade_id'))
        ->Where('division_id',request('division_id'))
        ->Where('year_id',request('year_id'))
        ->get();
        
        if (request()->ajax()) {
            return $this->dataTable($data);
        } 
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('classrooms.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('division_id',function($data){
                        return session('lang') == 'ar' ? 
                        $data->division->ar_division_name : $data->division->en_division_name;
                    })
                    ->addColumn('year_id',function($data){
                        return $data->year->name;
                    })
                    ->addColumn('grade_id',function($data){
                        return session('lang') == 'ar' ? 
                        $data->grade->ar_grade_name : $data->grade->en_grade_name;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check'])
                    ->make(true);
    }
    public function getClassrooms()
    {
        $output = '';
        if (!empty(request('division_id')) && !empty(request('grade_id')) ) {
            $where = [
                ['division_id',request('division_id')],
                ['grade_id',request('grade_id')],
                ['year_id',currentYear()]
            ];
            $classrooms = Classroom::where($where)->get();
                
            foreach ($classrooms as $room) {
                $roomName = session('lang') == 'ar' ? $room->ar_name_classroom : $room->en_name_classroom;
                $output .= '<option value="'.$room->id.'">'.$roomName.'</option>';
            }
            return json_encode($output);
        }
    }
}
