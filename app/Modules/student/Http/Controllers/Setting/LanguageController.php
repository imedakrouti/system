<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Student\Models\Settings\Language;
use Illuminate\Http\Request;
use Student\Http\Requests\LanguageRequest;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Language::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('languages.edit',$data->id).'">
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
        return view('student::settings.languages.index',
        ['title'=>trans('student::local.languages')]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.languages.create',
        ['title'=>trans('student::local.new_language')]);
    }

    private function attributes()
    {
        return [            
            'ar_name_lang',
            'en_name_lang',
            'lang_type',
            'sort', 
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $request->user()->languages()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('languages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('student::settings.languages.edit',
        ['title'=>trans('student::local.edit_language'),'language'=>$language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, Language $language)
    {
        $language->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('languages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Language::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
