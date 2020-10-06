<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use File;
use Student\Models\Settings\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Student\Http\Requests\DesignRequest;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('student::local.id_designs');
        $designs = Design::with('grade','division')->orderBy('id','desc')->paginate(6);
        
        return view('student::settings.id-designs.index',
        compact('grades','divisions','title','designs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::sort()->get();      
        $divisions = Division::sort()->get();
        $title = trans('student::local.new_id_design');
        return view('student::settings.id-designs.create',
        compact('grades','divisions','title'));
    }

    private function attributes()
    {
        return [                                    
            'division_id',   
            'grade_id',  
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignRequest $request)
    {
        $image_path = public_path()."/images/id-designs/".settingHelper()->design_name;                 
        $design_name = uploadFileOrImage($image_path,request('design_name'),'images/id-designs');

        $request->user()->designs()->create($request->only($this->attributes())
            + ['design_name'=>  $design_name]); 
               
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('id-designs.index');
    }
    private function uploadDesign($design = null)
    {

        
        $fileName = '';           
        $designImage = !empty($design) ? $design : '';    
       
        if (request()->has('design_name'))
        {
            if (!empty($designImage)) {                                
                Storage::delete('public/id-designs/'.$designImage->design_name);    
            }
            
            $imagePath = request()->file('design_name')->store('public/id-designs');
          
            $imagePath = explode('/',$imagePath);
            $imagePath = $imagePath[2];
                        
            $data['design_name'] = $imagePath;
        }                          
        
        return $imagePath ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $design = Design::findOrFail($id);
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('student::local.edit_id_design');
        return view('student::settings.id-designs.edit',
        compact('grades','divisions','title','design'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(DesignRequest $request, $id)
    {         
        $design = Design::findOrFail($id);
        if (request()->has('design_name')) {
            $image_path = public_path()."/images/id-designs/".settingHelper()->design_name;                 
            $design_name = uploadFileOrImage($image_path,request('design_name'),'images/id-designs');
            $design->update($request->only($this->attributes())
            + ['design_name'=>  $design_name]);            
        }else{
            $design->update($request->only($this->attributes()));
        }
        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('id-designs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $design = Design::findOrFail($id);                    
        
        $file_path = public_path()."/images/id-designs/".$design->design_name;                                                             
        removeFileOrImage($file_path); // remove file from directory
        $design->delete();
        toast(trans('msg.delete_successfully'),'success');
        return redirect()->route('id-designs.index');       
    }
    public function filter()
    {
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('student::local.id_designs');
        $designs = Design::with('grade','division')
        ->where('division_id',request('division_id'))
        ->where('grade_id',request('grade_id'))
        ->orderBy('id','desc')->paginate(6);
        // dd($designs);
        return view('student::settings.id-designs.index',
        compact('grades','divisions','title','designs'));
    }
}
