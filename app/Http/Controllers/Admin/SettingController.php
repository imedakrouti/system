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
            'siteNameArabic'    =>'required',
            'siteNameEnglish'   =>'required',
            'openTime'          =>'required',
            'closeTime'         =>'required',
            'logo'              => 'image|mimes:jpg,jpeg,png|max:2048',
            'icon'              => 'mimes:ico',
        ],[
            'siteNameArabic.required'   => trans('msg.site_arabic_name_required'),
            'siteNameEnglish.required'  => trans('msg.site_english_name_required'),
            'openTime.required'         => trans('msg.open_time_required'),
            'closeTime.required'        => trans('msg.close_time_required'),
            'logo.image'                => trans('msg.logo_image_validate'),
            'logo.mimes'                => trans('msg.logo_mimes_validate'),
            'icon.mimes'                => trans('msg.icon_mimes_validate'),
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
