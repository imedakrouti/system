<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function siteSettingPage()
    {
        return view('admin.settings.siteSettings',['title'=>trans('admin.site_setting')]);
    }
    public function updateSettings()
    {
        $data = $this->validate(request(),[
            'ar_school_name'    => 'required',
            'en_school_name'    => 'required',
            'open_time'         => 'required',
            'close_time'        => 'required'            
        ],[
            'ar_school_name.required'   => trans('msg.ar_school_name_required'),
            'en_school_name.required'   => trans('msg.en_school_name_required'),
            'open_time.required'        => trans('msg.open_time_required'),
            'close_time.required'       => trans('msg.close_time_required'),

        ]);
        $data = request()->except('_token','_method','query_string');

        if (request()->hasFile('logo'))
        {            
            $image_path = public_path()."/images/website/".settingHelper()->logo;                 
            $data['logo'] =uploadFileOrImage($image_path,request('logo'),'images/website');
        }
        if (request()->hasFile('icon'))
        {
            $image_path = public_path()."/images/website/".settingHelper()->icon;                 
            $data['icon'] =uploadFileOrImage($image_path,request('icon'),'images/website');
        }
        // unset($data["/admin/setting"]);
        // update settings
        Setting::orderBy('id','desc')->update($data);
        alert()->success('', trans('msg.setting_updated'));
        return redirect(aurl('settings'));
    }

}
