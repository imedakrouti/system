<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Staff\Models\Employees\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('staff::local.announcements');
        $announcements = Announcement::with('admin')->orderBy('id','desc')->paginate(5);
        return view('staff::announcements.index',
        compact('title','announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $title = trans('staff::local.new_announcement');
        return view('staff::announcements.create',
        compact('title'));
    }
    private function attributes()
    {
        return ['announcement','start_at','end_at','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        foreach (request('domain_role') as $role) {
            request()->user()->announcements()->firstOrCreate($request->only($this->attributes())+
                [ 'domain_role' => $role]);                    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('announcements.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        $title = trans('staff::local.edit_announcement');
        return view('staff::announcements.edit',
        compact('title','announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update($request->only($this->attributes())+['domain_role' => request('domain_role')]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('announcements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        if (request()->has('id')) {
            foreach (request('id') as $id) {
                Announcement::where('id',$id)->delete();
            }
        }else{
            toast(trans('staff::local.no_announcement_selected'),'error');
            return back();
        }
        toast(trans('msg.delete_successfully'),'success');
        return redirect()->route('announcements.index');
    }
}
