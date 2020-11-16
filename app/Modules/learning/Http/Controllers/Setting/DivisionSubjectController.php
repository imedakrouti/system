<?php

namespace Learning\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Learning\Models\Settings\DivisionSubject;
use Learning\Models\Settings\Subject;
use Student\Models\Settings\Division;

class DivisionSubjectController extends Controller
{
    public function index()
    {
        $title = trans('learning::local.division_subjects');
        $data = Division::has('subjects')->get();    
        
        // dd($data);
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::settings.division-subjects.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()                       
                    ->addColumn('division',function($data){                        
                      return session('lang') == 'ar' ? $data->ar_division_name: $data->en_division_name;
                    })              
                    ->addColumn('subjects',function($data){                        
                        $subject_name = '';
                        foreach ($data->subjects as $subject) {     
                            $sub = session('lang') == 'ar' ? $subject->ar_name : $subject->en_name;
                            $subject_name .= '<div class="badge badge-primary">
                                                <span>'. $sub.'</span>
                                                <i class="la la-folder-o font-medium-3"></i>
                                            </div> ' ;
                        }
                        return $subject_name;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','subjects','grade'])
                    ->make(true);
    }
    public function create()
    {                
        $divisions = Division::sort()->get();
        $subjects = Subject::sort()->get();
        $title = trans('learning::local.add_division_subject');
        return view('learning::settings.division-subjects.create',
        compact('divisions','subjects','title'));
    }

    public function store()
    {
        if (request()->has('division_id','subject_id')) {
            foreach (request('division_id') as $division_id) {
                foreach (request('subject_id') as $subject_id) {
                  request()->user()->divisionSubjects()->firstOrCreate([                      
                      'division_id'      => $division_id,
                      'subject_id'    => $subject_id,                        
                  ]);
                }
            }
            toast(trans('msg.stored_successfully'),'success');
        }
        return redirect()->route('division-subjects.index');
    }

    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $division_id) {
                    DivisionSubject::where('division_id',$division_id)->delete();
                }
            }
        }
        return response(['status'=>true]);
    }
}
