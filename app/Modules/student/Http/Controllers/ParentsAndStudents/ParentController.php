<?php

namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;

use DB;
use Student\Http\Requests\FatherRequest;
use Student\Http\Requests\MotherRequest;
use Student\Models\Parents\Father;
use Student\Models\Parents\Mother;
use Student\Models\Settings\Nationality;

class ParentController extends Controller
{
    private $father;
    private $father_id;
    private $mother;

    public function index()
    {
        if (request()->ajax()) {
            $data = Father::with('mothers','nationalities')->get();                  
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('father_name',function($data){
                        $nationality = session('lang') =='ar' ? $data->nationalities->ar_name_nat_male :
                        $data->nationalities->en_name_nationality;

                        $fatherName = $this->getFatherName($data);

                        return '<a href="'.route('father.show',$data->id).'">'.$fatherName.'</a></br>'
                        .$nationality;
                    })
                    ->addColumn('mobile',function($data){
                        return $data->mobile1 . '</br>' . $data->mobile2;
                    })
                    ->addColumn('mother_name',function($data){
                        $motherName = '';
                        foreach ($data->mothers as $mother) {  
                            $nationality = session('lang') =='ar' ? 
                            $mother->nationalities->ar_name_nat_female : $data->nationalities->en_name_nationality;                                                      
                            $motherName .= '<a class="a-hover" href="'.route('mother.show',$mother->id).'">'.$mother->full_name.'</a> 
                            ['.$nationality . ']</br>';
                        }
                        return $motherName;
                    })
                    ->addColumn('mother_mobile',function($data){
                        $mobileNumber = '';
                        foreach ($data->mothers as $mother) {                                                       
                            $mobileNumber .= $mother->mobile1_m .'</br>';
                        }
                        return $mobileNumber;
                    })                    
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','father_name','mother_name','mother_mobile','mobile'])
                    ->make(true);
        }
        return view('student::parents.index',
        ['title'=>trans('student::local.parents')]);  
    }
    private function getFatherName($father)
    {
        return session('lang') == 'ar' ?
        $father->ar_st_name .' '.$father->ar_nd_name .' '.$father->ar_rd_name .' '.$father->ar_th_name :
        $father->en_st_name .' '.$father->en_nd_name .' '.$father->en_rd_name .' '.$father->en_th_name;  
    }
    private function fatherAttributes()
    {
        return [
            'ar_st_name' ,
            'ar_nd_name' ,
            'ar_rd_name' ,
            'ar_th_name' ,
            'en_st_name' ,
            'en_nd_name' ,
            'en_rd_name' ,
            'en_th_name' ,
            'id_type' ,
            'id_number' ,
            'home_phone' ,
            'mobile1' ,
            'mobile2' ,
            'job' ,
            'email' ,
            'qualification' ,
            'facebook' ,
            'whatsapp_number' ,
            'nationality_id' ,
            'religion' ,
            'educational_mandate' ,
            'block_no' ,
            'street_name' ,
            'state' ,
            'government' ,
            'marital_status' ,
            'recognition' ,                    
        ];
    }
    private function motherAttributes()
    {
        return 
        [
            'full_name' ,
            'id_type_m' ,
            'id_number_m' ,
            'home_phone_m' ,
            'mobile1_m' ,
            'mobile2_m' ,
            'job_m' ,
            'email_m' ,
            'qualification_m' ,
            'facebook_m' ,
            'whatsapp_number_m' ,
            'nationality_id_m' ,
            'religion_m' ,
            'block_no_m' ,
            'street_name_m' ,
            'state_m' ,
            'government_m' ,
            'admin_id_m' ,
        ];
    }
    public function create()
    {
        $nationalities = Nationality::sort()->get();
        $title = trans('student::local.new_parent');
        return view('student::parents.create',
        compact('nationalities','title'));
    }
    public function store(FatherRequest $fatherRequest,MotherRequest $motherRequest)
    {
        $this->father = $fatherRequest->only($this->fatherAttributes());
        $this->mother = $motherRequest->only($this->motherAttributes());
        
        DB::transaction(function () use ($fatherRequest,$motherRequest) {            
            $fatherData = $fatherRequest->user()->fathers()->create($this->father);        
            $motherData = $motherRequest->user()->mothers()->create($this->mother);    
            $this->father_id = $fatherData->id;
            $father = Father::find($this->father_id);
            $father->mothers()->attach($motherData->id);            
        });
            
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father.show',$this->father_id);
    }
    public function destroy()
    {                
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                DB::transaction(function () {    
                foreach (request('id') as $id) {
                        $mothers = DB::table('father_mother')->where('father_id',$id)->get();  
                        foreach ($mothers as $mother) {
                            Mother::destroy($mother->mother_id);                            
                        }
                        $father = Father::findOrFail($id);
                        
                        Father::destroy($id);
                        $father->mothers()->detach();
                    }
                });
            }
        }
        return response(['status'=>true]);
    }
    public function fatherShow($id)
    {
        $title = trans('student::local.father_data');    
        $father = Father::with('students')->findOrFail($id);    
        return view('student::parents.fathers.father-show',
        compact('title','id','father'));
    }
    public function editFather($id)
    {
        $nationalities = Nationality::sort()->get();
        $father = Father::findOrFail($id);
        $title = trans('student::local.edit_father_data');
        return view('student::parents.fathers.father-edit',
        compact('nationalities','title','father'));
    }
    public function updateFather(FatherRequest $request,$id)
    {        
        $father = Father::findOrFail($id);
        $father->update($request->only($this->fatherAttributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('father.show',$id);
    }
    public function addWife($id)
    {
        $nationalities = Nationality::sort()->get();   
        $father = Father::findOrFail($id);
        $fatherName = $this->getFatherName($father);
        $title = trans('student::local.add_mother');
        return view('student::parents.fathers.add-wife',
        compact('nationalities','title','id','fatherName'));
    }
    public function storeWife(MotherRequest $request)
    {        
        DB::transaction(function () use ($request) {            
            $motherData = $request->user()->mothers()->create($request->only($this->motherAttributes()));        

            $mother = Mother::find($motherData->id);
            $mother->fathers()->attach($request->father_id);            
        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('parents.index');
    }
    public function motherShow($id)
    {
        $title = trans('student::local.mother_data');  
        $mother = Mother::with('fathers','students')->findOrFail($id);  

        return view('student::parents.mothers.mother-show',
        compact('title','id','mother'));
    }
    public function editMother($id)
    {
        $nationalities = Nationality::sort()->get();
        $mother = Mother::findOrFail($id);
        $title = trans('student::local.edit_mother_data');
        return view('student::parents.mothers.mother-edit',
        compact('nationalities','title','mother'));
    }
    public function updateMother(MotherRequest $request,$id)
    {        
        $mother = Mother::findOrFail($id);
        $mother->update($request->only($this->motherAttributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('parents.index');
    }
    public function addHusband($id)
    {
        $nationalities = Nationality::sort()->get();   
        $mother = Mother::findOrFail($id);
        $motherName = $mother->full_name;
        $title = trans('student::local.add_father');
        return view('student::parents.mothers.add-husband',
        compact('nationalities','title','id','motherName'));
    }
    public function storeHusband(FatherRequest $request)
    {        
        DB::transaction(function () use ($request) {            
            $fatherData = $request->user()->fathers()->create($request->only($this->fatherAttributes()));        
            $this->father_id = $fatherData->id;
            $father = father::find($fatherData->id);
            $father->mothers()->attach($request->mother_id);            
        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father.show',$this->father_id);
    }

}
