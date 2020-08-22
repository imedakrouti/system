<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use File;
use Illuminate\Http\Request;

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
            $image_path = public_path("/images/website/".settingHelper()->logo);
            // return dd($image_path);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $logo = request('logo');
            $fileName = time().'-'.$logo->getClientOriginalName();
            $location = public_path('images/website');
            $logo->move($location,$fileName);
            $data['logo'] = $fileName;
        }
        if (request()->hasFile('icon'))
        {
            // remove old image
            $image_path = public_path("/images/website/".settingHelper()->icon);
            // return dd($image_path);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $icon = request('icon');
            $fileName = time().'-'.$icon->getClientOriginalName();
            $location = public_path('images/website');
            $icon->move($location,$fileName);
            $data['icon'] = $fileName;
        }
        unset($data["/admin/setting"]);
        // update settings
        Setting::orderBy('id','desc')->update($data);
        alert()->success('', trans('msg.setting_updated'));
        return redirect(aurl('settings'));
    }
}
