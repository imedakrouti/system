<?php

namespace Student\Http\Controllers\Parents;
use App\Http\Controllers\Controller;
use App\Http\Requests\FatherMotherRequest;
use Illuminate\Http\Request;
use DB;
use Student\Models\Parents\Father;
use Student\Models\Parents\Mother;
use Student\Models\Settings\Nationality;

class ParentController extends Controller
{
    private $father;
    private $mother;

    public function index()
    {
        // dd($data);  
        if (request()->ajax()) {
            $data = Father::with('mothers','nationalities')->get();          
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('father_name',function($data){
                        $nationality = session('lang') ==trans('admin.ar') ? $data->nationalities->ar_name_nat_male :
                        $data->nationalities->en_name_nationality;

                        $fatherName = session('lang') == trans('admin.ar') ?
                        $data->ar_st_name .' '.$data->ar_nd_name .' '.$data->ar_rd_name .' '.$data->ar_th_name :
                        $data->en_st_name .' '.$data->en_nd_name .' '.$data->en_rd_name .' '.$data->en_th_name;                                                

                        return '<a href="'.route('father.show',$data->id).'">'.$fatherName.'</a></br>'
                        .$nationality;
                    })
                    ->addColumn('mother_name',function($data){
                        foreach ($data->mothers as $mother) {  
                            $nationality = session('lang') ==trans('admin.ar') ? $mother->nationalities->ar_name_nat_female :
                        $data->nationalities->en_name_nationality;                          
                            return $mother->full_name .'</br>'.$nationality ;
                        }
                    })
                    ->addColumn('mother_mobile',function($data){
                        foreach ($data->mothers as $mother) {                                                       
                            return $mother->mobile1_m;
                        }
                    })
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('parents.edit',$data->id).'">
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
                    ->rawColumns(['action','check','father_name','mother_name','mother_mobile'])
                    ->make(true);
        }
        return view('student::parents.index',
        ['title'=>trans('student::local.parents')]);  
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
    public function store(FatherMotherRequest $request)
    {
        $this->father = $request->only($this->fatherAttributes());
        $this->mother = $request->only($this->motherAttributes());
        
        DB::transaction(function () use ($request) {            
            $fatherData = $request->user()->fathers()->create($this->father);        
            $motherData = $request->user()->mothers()->create($this->mother);    
            
            $father = Father::find($fatherData->id);
            $father->mothers()->attach($motherData->id);            
        });
            
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('parents.index');
    }

    

}
