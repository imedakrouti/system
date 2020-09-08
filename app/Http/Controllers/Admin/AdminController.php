<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Admin::orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('accounts.edit',$data->id).'">
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
        return view('admin.accounts.index',['title'=>trans("admin.users_accounts")]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.accounts.create',['title'=>trans('admin.new_account')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        Admin::create($request->all());        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('accounts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admins = Admin::findOrFail($id);
        return view('admin.accounts.edit',['title'=>trans('admin.edit_user_account'),'admins'=>$admins]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update($request->except('_token','_method','/admin/admin/profile'));        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Admin::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function userProfile()
    {
        return view('admin.accounts.userProfile',['title'=> trans('admin.profile')]);
    }
    private function roleProfile()
    {
        return [
            'imageProfile'       => 'image|mimes:jpg,jpeg,png|max:1024',
        ];
    }
    private function msgProfile()
    {
        return [
            'image_profile.image' => trans('admin.logoImageValidate'),
            'image_profile.mimes' => trans('admin.logoMimesValidate'),
        ];
    }
    public function updateProfile()
    {
        $data = $this->validate(request(),$this->roleProfile(),$this->msgProfile());

        $data = request()->except('_token','_method','/admin/admin/profile');

        if (request()->hasFile('image_profile'))
        {
            // remove old image
            $image_path = public_path("/images/imagesProfile/".authInfo()->image_profile);
            // return dd($image_path);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image_profile = request('image_profile');
            
            $fileName = $image_profile->getClientOriginalName();            
            
            $imagePath = request()->file('image_profile')->store('public/imageProfile');
            $imagePath = explode('/',$imagePath);
            $imagePath = $imagePath[2];
                        
            $data['image_profile'] = $imagePath;
        }

        Admin::where('id',authInfo()->id)->update($data);

        session()->forget('lang');
        session()->put('lang',authInfo()->lang);
        toast(trans('msg.updated_successfully'),'success');

        
        return back();
    }
}
