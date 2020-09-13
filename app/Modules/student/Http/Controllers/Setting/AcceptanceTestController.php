<?php
namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Student\Models\Settings\AcceptanceTest;
use Illuminate\Http\Request;
use Student\Http\Requests\AcceptanceTestRequest;
use Student\Models\Settings\Grade;

class AcceptanceTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = AcceptanceTest::with('grades')->latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('acceptance-tests.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('grade_id',function($data){
                        return session('lang') =='ar' ? 
                        $data->grades->ar_grade_name : $data->grades->en_grade_name;
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
        return view('student::settings.acceptance-tests.index',['title'=>trans('student::local.acceptance_tests')]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::sort()->get();        
        return view('student::settings.acceptance-tests.create',
        ['title'=>trans('student::local.new_admission_test'),'grades'=>$grades]);
    }
    private function attributes()
    {
        return [
            'ar_test_name',
            'en_test_name',            
            'sort'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcceptanceTestRequest $request)
    {
        foreach ($request->grade_id as $grade_id) {
            $request->user()->acceptanceTest()->create($request->only($this->attributes())
            + ['grade_id' => $grade_id]);                    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('acceptance-tests.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AcceptanceTest  $AcceptanceTest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $acceptanceTest = AcceptanceTest::findOrFail($id);
        $grades = Grade::sort()->get();  
        return view('student::settings.acceptance-tests.edit',
        ['title'=>trans('student::local.edit_admission_test'),
        'acceptanceTest'=>$acceptanceTest,'grades'=>$grades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AcceptanceTest  $AcceptanceTest
     * @return \Illuminate\Http\Response
     */
    public function update(AcceptanceTestRequest $request, $id)
    {
        $acceptanceTest = AcceptanceTest::findOrFail($id);        
        $acceptanceTest->update($request->only($this->attributes())
            + ['grade_id' => $request->grade_id]);                                  
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('acceptance-tests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AcceptanceTest  $AcceptanceTest
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcceptanceTest $acceptanceTest)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    AcceptanceTest::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
