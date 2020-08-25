<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Http\Requests\InterviewRequest;
use Student\Models\Settings\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Interview::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('interviews.edit',$data->id).'">
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
        return view('student::settings.interviews.index',
        ['title'=>trans('student::local.interviews')]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.interviews.create',
        ['title'=>trans('student::local.new_interview')]);
    }
    private function attributes()
    {
        return [            
            'ar_name_interview',
            'en_name_interview',
            'sort'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InterviewRequest $request)
    {
        $request->user()->interviews()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('interviews.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interview  $Interview
     * @return \Illuminate\Http\Response
     */
    public function edit(Interview $interview)
    {
        return view('student::settings.interviews.edit',
        ['title'=>trans('student::local.edit_interview'),'interview'=>$interview]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interview  $Interview
     * @return \Illuminate\Http\Response
     */
    public function update(InterviewRequest $request, Interview $interview)
    {
        $interview->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('interviews.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interview  $Interview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interview $Interview)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Interview::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
