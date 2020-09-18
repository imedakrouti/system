<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Student\Models\Settings\Grade;
use Student\Models\Students\SetMigration;

class SetMigrationController extends Controller
{    
    public function index()
    { 
        if (request()->ajax()) {
            $data = SetMigration::all();
            return datatables($data)
                    ->addIndexColumn()                    
                    ->addColumn('from_grade_id',function($data){
                       return session('lang') == 'ar'? $data->fromGrade->ar_grade_name : 
                       $data->fromGrade->en_grade_name;
                    })
                    ->addColumn('to_grade_id',function($data){
                        return session('lang') == 'ar'? $data->toGrade->ar_grade_name : 
                        $data->toGrade->en_grade_name;
                     })                 
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','from_grade_id','to_grade_id'])
                    ->make(true);
        }
        $title = trans('student::local.set_migration');
        $grades = Grade::sort()->get();
        return view('student::students-affairs.students-statements.set-migration',
        compact('title','grades'));
    } 
    public function storeSetMigration()
    {        
        if (request()->ajax()) {
            
            request()->user()->setMigration()->create([
                'from_grade_id'=> request('from_grade_id'),
                'to_grade_id'=> request('to_grade_id')
                ]);                  
        }
        return response(['status' => 'true']);
    }
    public function destroy()
    {        
        // dd(request()->all());
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    SetMigration::destroy($id);                        
                }
            }
        }
        return response(['status'=>true]);
    }      
}
