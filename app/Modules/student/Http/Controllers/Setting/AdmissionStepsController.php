<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Student\Models\Settings\Step;
use Illuminate\Http\Request;
use Student\Http\Requests\AdmissionStepsRequest;
use DB;

class AdmissionStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Step::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('steps.edit',$data->id).'">
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
        return view('student::settings.admission-steps.index',['title'=>trans('student::local.steps')]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.admission-steps.create',
        ['title'=>trans('student::local.new_step')]);
    }
    private function attributes()
    {
        return [
            'ar_step',
            'en_step',
            'sort',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionStepsRequest $request)
    {
        $request->user()->steps()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('steps.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function edit(Step $step)
    {
        return view('student::settings.admission-steps.edit',
        ['title'=>trans('student::local.edit_step'),'step'=>$step]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionStepsRequest $request, Step $step)
    {
        $step->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('steps.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function destroy(Step $step)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Step::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function getStepsSelected()
    {
        $id = request()->get('id');        
        $output = "";
        
        $steps = Step::all();
        foreach ($steps as $step) {
            
            $step_id = DB::table('student_steps')->select('admission_step_id')
            ->where('student_id',$id)->where('admission_step_id',$step->id)->first();
            
            $stepValue = !empty($step_id->admission_step_id)?$step_id->admission_step_id:0;
            
            $checked = $step->id == $stepValue ?"checked":"";
               $stepName = session('lang')== trans('admin.ar')?$step->ar_step:$step->en_step;
            $output .= '<li><label class="pos-rel">
                        <input type="checkbox" class="ace" name="admission_step_id[]" '.$checked.' value="'.$step->id.'" />
                        <span class="lbl"></span> '.$stepName.'
                    </label></li>';
        };
        
        return json_encode($output);
    }
}
