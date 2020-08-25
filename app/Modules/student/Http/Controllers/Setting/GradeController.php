<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Http\Requests\GradeRequest;
use Student\Models\Settings\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Grade::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('grades.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
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
        return view('student::settings.grades.index',['title'=>trans('student::local.grades')]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.grades.create',
        ['title'=>trans('student::local.new_grade')]);
    }
    private function attributes()
    {
        return [
            'ar_grade_name',
            'en_grade_name',
            'ar_grade_parent',
            'en_grade_parent',
            'from_age_year',
            'from_age_month',
            'to_age_year',
            'to_age_month',
            'sort',
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeRequest $request)
    {
        $request->user()->grades()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('grades.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        return view('student::settings.grades.edit',
        ['title'=>trans('student::local.edit_grade'),'grade'=>$grade]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(GradeRequest $request, Grade $grade)
    {
        $grade->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('grades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Grade::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    private function grades()
    {
        $grades = Grade::all();
        foreach ($grades as $grade) {
            $grade->setAttribute('gradeName',session('lang')=='en'?$grade->ar_grade_name:$grade->en_grade_name);
        }
        return $grades;
    }
    public function getGrades()
    {
        $output = "";
        $output .='<option value="">'.trans('admin.select').'</option>';
        foreach ($this->grades() as $grade) {
            $output .= ' <option value="'.$grade->id.'">'.$grade->gradeName.'</option>';
        };
        return json_encode($output);
    }
    public function getGradeSelected()
    {
        $id = request()->get('grade_id');
        $output = "";
        $output .='<option value="">'.trans('admin.select').'</option>';
        foreach ($this->grades() as $grade) {
            $selected = $grade->id == $id?"selected":"";
            $output .= ' <option '.$selected.' value="'.$grade->id.'">'.$grade->gradeName.'</option>';
        };
        return json_encode($output);
    }     
}
