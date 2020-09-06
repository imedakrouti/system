<?php
namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;
use Student\Models\Admissions\Meeting;

class CalendarController extends Controller 
{
    public function showMeetings()
    {
        if (request()->ajax()) {
            $data = [];
            $meetings = Meeting::with('fathers')->get();
            foreach ($meetings as  $value) {
                $color = '';
                switch ($value->meeting_status) {
                    case trans('student::local.meeting_pending'):
                        $color = '#FF9149';
                        break;
                    case trans('student::local.meeting_canceled'):
                        $color = '#FF4961';
                        break;
                    default:
                        $color = '#28D094';
                        break;
                }
                $fatherName = session('lang')==trans('admin.ar') ?
                $value->fathers->ar_st_name .' '.$value->fathers->ar_nd_name .' '.$value->fathers->ar_rd_name:
                $value->fathers->en_st_name .' '.$value->fathers->en_nd_name .' '.$value->fathers->en_rd_name ;

                $data[] = array(
                    'id'        => $value->id,
                    'title'     => $fatherName . ' [ '.trans('student::local.parent').' ]',
                    'start'     => $value->start,
                    'end'       => $value->end,
                    'color'     => $color
                   );
            }
            return json_encode($data);
        }
        return view('student::admissions.calendar.calendar',['title'=>trans('student::local.calendar')]);
    }
}
