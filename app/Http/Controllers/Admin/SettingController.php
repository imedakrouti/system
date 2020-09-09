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
        $data = request()->except('_token','_method');

        if (request()->hasFile('logo'))
        {
            // remove old image           
            Storage::delete('public/logo/'.settingHelper()->logo);
            $imagePath = request()->file('logo')->store('public/logo');
            $imagePath = explode('/',$imagePath);
            $imagePath = $imagePath[2];                        
            $data['logo'] = $imagePath;
        }
        if (request()->hasFile('icon'))
        {
            // remove old image           
            Storage::delete('public/icon/'.settingHelper()->icon);
            $imagePath = request()->file('icon')->store('public/icon');
            $imagePath = explode('/',$imagePath);
            $imagePath = $imagePath[2];                        
            $data['icon'] = $imagePath;
        }
        unset($data["/admin/setting"]);
        // update settings
        Setting::orderBy('id','desc')->update($data);
        alert()->success('', trans('msg.setting_updated'));
        return redirect(aurl('settings'));
    }
}
