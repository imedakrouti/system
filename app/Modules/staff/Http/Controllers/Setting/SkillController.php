<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Staff\Http\Requests\SkillRequest;
use Staff\Models\Settings\Skill;
use DB;
class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Skill::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('skills.edit',$data->id).'">
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
        return view('staff::settings.skills.index',
        ['title'=>trans('staff::local.skills')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.skills.create',
        ['title'=>trans('staff::local.new_skill')]);
    }
    private function attributes()
    {
        return ['ar_skill','en_skill','sort','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillRequest $request)
    {
        $request->user()->skills()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('skills.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        return view('staff::settings.skills.edit',
        ['title'=>trans('staff::local.edit_skill'),'skill'=>$skill]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skill $skill
     * @return \Illuminate\Http\Response
     */
    public function update(SkillRequest $request, Skill $skill)
    {
        $skill->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('skills.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Skill::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function getSkillsSelected()
    {        
        $employee_id = request()->get('employee_id');        
        $output = "";
        
        $skills = Skill::sort()->get();
        foreach ($skills as $skill) {
            
            $skill_id = DB::table('employee_skills')->select('skill_id')
            ->where('employee_id',$employee_id)->where('skill_id',$skill->id)->first();
            
            $skillValue = !empty($skill_id->skill_id)?$skill_id->skill_id:0;
            
            $checked = $skill->id == $skillValue ?"checked":"";
            $skillName = session('lang')== 'ar'?$skill->ar_skill:$skill->en_skill;
            $output .= '<h5><li><label class="pos-rel">
                        <input type="checkbox" class="ace" name="skill_id[]" '.$checked.' value="'.$skill->id.'" />
                        <span class="lbl"></span> '.$skillName.'
                    </label></li></h5>';
        };
        
        return json_encode($output);
    }
}
