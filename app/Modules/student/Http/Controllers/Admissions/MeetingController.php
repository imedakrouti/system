<?php

namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingRequest;
use Student\Models\Admissions\Meeting;
use Illuminate\Http\Request;
use Student\Models\Parents\Father;
use Student\Models\Settings\Interview;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Meeting::with('fathers','interviews')->latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('meetings.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('father_name',function($data){
                        return $this-> getFatherName($data);
                    })
                    ->addColumn('interview_id',function($data){
                        return session('lang') == trans('admin.ar') ? $data->interviews->ar_name_interview :
                        $data->interviews->en_name_interview;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','father_name','interview_id'])
                    ->make(true);
        }
        return view('student::admissions.interviews-dates.index',['title'=>trans('student::local.interviews_dates')]);
    }
    private function getFatherName($data)
    {
        return session('lang') == trans('admin.ar') ?
        '<a href="'.route('father.show',$data->father_id).'" >'.$data->fathers->ar_st_name .' '.$data->fathers->ar_nd_name .' '.$data->fathers->ar_rd_name .' '.$data->fathers->ar_th_name .'</a>':
        $data->fathers->en_st_name .' '.$data->fathers->en_nd_name .' '.$data->fathers->en_rd_name .' '.$data->fathers->en_th_name;  
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fathers = Father::all();
        $interviews = Interview::all();
        $title = trans('student::local.new_interview');
        return view('student::admissions.interviews-dates.create',
        compact('fathers','interviews','title'));
    }
    private function attributes()
    {
        return [            
            'interview_id',            
            'start',
            'end',
            'meeting_status',
            'notes',            
            'admin_id',               
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingRequest $request)
    {
        // dd($request->father_id);
        foreach ($request->father_id as $fatherId) {
            $request->user()->meetings()->create($request->only($this->attributes())
            + ['father_id' => $fatherId]);        
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('meetings.index');            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        $fathers = Father::all();
        return view('student::admissions.interviews-dates.edit',
        ['title'=>trans('student::local.edit_meeting'),'meeting'=>$meeting,'fathers'=>$fathers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $meeting->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Meeting::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function fatherMeetings($fatherId)
    {
        $father = Father::findOrFail($fatherId);
        $title = trans('student::local.meetings');
        $meetings =  Meeting::with('fathers','interviews')->whereHas('fathers',function($q) use ($fatherId){
            $q->where('father_id',$fatherId);
        })->get();

        return view('student::admissions.interviews-dates.father-meetings',
        compact('father','title','meetings'));
    }
    public function fatherAttend()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {                                        
                    Meeting::where('id',$id)->update(['meeting_status' => 'done']);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function fatherPending()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {                                        
                    Meeting::where('id',$id)->update(['meeting_status' => 'pending']);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function fatherCanceled  ()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {                                        
                    Meeting::where('id',$id)->update(['meeting_status' => 'canceled']);
                }
            }
        }
        return response(['status'=>true]);
    }
}
