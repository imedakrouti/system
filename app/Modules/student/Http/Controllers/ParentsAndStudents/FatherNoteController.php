<?php


namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Student\Models\Parents\Father;
use Student\Models\Students\Note;
use Student\Models\Students\Student;

class FatherNoteController extends Controller
{
    public function index($father_id)
    {
        if (request()->ajax()) {
            $data = Note::with('fathers')->where('father_id',$father_id)->orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('father-notes.edit',$data->id).'">
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
        $father = Father::findOrFail($father_id);        
        $title = trans('student::local.notes');        
        return view('student::students-affairs.notes.father.index',
        compact('title','father'));
    }

    public function create($father_id)
    {
        $father = Father::findOrFail($father_id);
        $title = trans('student::local.add_notes');
        return view('student::students-affairs.notes.father.create',
        compact('father','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {                
        request()->user()->notes()->create(['father_id' =>request('father_id'),'notes'=>request('notes')]);
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father-notes.index',request('father_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $father = Father::findOrFail($note->father_id);
        $title = trans('student::local.edit_notes');
        return view('student::students-affairs.notes.father.edit',
        compact('father','title','note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $note = Note::findOrFail($id);
        $note->update(['father_id' =>request('father_id'),'notes'=>request('notes')]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('father-notes.index',request('father_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Note::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
 
}
