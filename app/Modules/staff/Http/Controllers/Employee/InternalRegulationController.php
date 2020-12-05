<?php
namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Staff\Models\Employees\InternalRegulation;

class InternalRegulationController extends Controller
{
    public function index()
    {
        $title = trans('staff::local.internal_regulation');
        $internal = InternalRegulation::first();
        return view('staff::internal-regulations.index',
        compact('title','internal'));
    }
    public function update()
    {
        $internal = InternalRegulation::first();
        $internal->update(request()->only(['internal_regulation_text','en_internal_regulation'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('internal-regulations.index');  
    }
    public function showForTeacher()
    {
        $title = trans('staff::local.internal_regulation');
        $internal = InternalRegulation::first();
        return view('staff::teacher.internal-regulation',
        compact('title','internal'));
    }
}
