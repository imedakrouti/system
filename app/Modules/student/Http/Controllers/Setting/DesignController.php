<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use File;
use Student\Models\Settings\Design;
use Illuminate\Http\Request;
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
        $request->user()->designs()->create($request->only($this->attributes())
            + ['design_name'=>  $this->uploadDesign()]); 
               
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
                $image_path = public_path("/images/designs/".$designImage->design_name);
                
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            
            $design_name = request('design_name');
            $fileName = time().'-'.$design_name->getClientOriginalName();
            
            $location = public_path('images/designs');
            
            $design_name->move($location,$fileName);
            $data['design_name'] = $fileName;
        }                          
        
        return empty($fileName) ? $designImage->design_name : $fileName ;
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
        $design->update($request->only($this->attributes())
        + ['design_name'=>  $this->uploadDesign($design)]);

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
        $image_path = public_path("/images/designs/".$design->design_name);

        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $design->delete();
        toast(trans('msg.delete_successfully'),'success');
        return redirect()->route('id-designs.index');       
    }
}
