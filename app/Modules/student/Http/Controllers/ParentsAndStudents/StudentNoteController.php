<?php


namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Student\Models\Parents\Father;
use Student\Models\Students\Note;
use Student\Models\Students\Student;

class StudentNoteController extends Controller
{
    public function index($student_id)
    {
        if (request()->ajax()) {
            $data = Note::with('fathers')->where('student_id',$student_id)->orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('student-notes.edit',$data->id).'">
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
        $student = Student::findOrFail($student_id);        
        $title = trans('student::local.notes');        
        return view('student::students-affairs.notes.student.index',
        compact('title','student'));
    }

    public function create($student_id)
    {
        $student = Student::findOrFail($student_id);
        $title = trans('student::local.add_notes');
        return view('student::students-affairs.notes.student.create',
        compact('student','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {                
        request()->user()->notes()->create(['student_id' =>request('student_id'),'notes'=>request('notes')]);
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('student-notes.index',request('student_id'));
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
        $student = Student::findOrFail($note->student_id);
        $title = trans('student::local.edit_notes');
        return view('student::students-affairs.notes.student.edit',
        compact('student','title','note'));
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
        $note->update(['student_id' =>request('student_id'),'notes'=>request('notes')]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('student-notes.index',request('student_id'));
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
