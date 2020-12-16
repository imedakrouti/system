<?php

namespace Staff\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\VacationRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Settings\LeaveType;
use DateTime;
use DateInterval;
use DatePeriod;
use Staff\Models\Employees\VacationPeriod;

class TeacherController extends Controller
{
    private $file_name;

    public function permissions()
    {
        $leave_types = LeaveType::sort()->get();
        return view('staff::teacher.permissions', compact('leave_types'));
    }



    public function vacations()
    {
        return view('staff::teacher.vacations');
    }

    private function attributes()
    {
        return  [
            'date_vacation',
            'from_date',
            'to_date',
            'vacation_type',
            'substitute_employee_id',
            'notes',
            'admin_id'
        ];
    }

    public function storeVacation(VacationRequest $request)
    {
        if (request()->ajax()) {
            $message = '';
            if ($this->getDaysCount() == 'invalid') {
                return response(['status' => 'invalid', 'msg' => trans('staff::local.invalid_vacation_period')]);
            }

            if (request()->hasFile('file_name')) {
                $this->file_name = uploadFileOrImage(null, request('file_name'), 'images/attachments');
            }

            foreach (request('employee_id') as $employee_id) {
                $employee = Employee::findOrFail($employee_id);

                $vacation_allocated = $employee->vacation_allocated;
                if (request('vacation_type') == trans('staff::local.regular_vacation') || request('vacation_type') == 'Regular vacation') { //vacation_type
                    if ($vacation_allocated < $this->getDaysCount() + 1) {
                        $message .=  ' - ' . trans('staff::local.check_vacation_balance') . ' [' . $employee->attendance_id . ' ]';
                    } else {
                        $this->insertVacation(request(), $employee_id, $vacation_allocated);
                    }
                } else {
                    $message = '';
                    $this->insertVacation(request(), $employee_id, $vacation_allocated);
                }
            }

            return response(['status' => true]);
        }
    }

    private function insertVacation($request, $employee_id, $vacation_allocated)
    {
        $vacation = $request->user()->vacations()->firstOrCreate($request->only($this->attributes()) +
            [
                'employee_id'       => $employee_id,
                'file_name'         => $this->file_name,
                'count'             => $this->getDaysCount(),
            ]);
        $this->InsertVacationPeriod($vacation, $employee_id);
        if (request('vacation_type') == trans('staff::local.regular_vacation') || request('vacation_type') == 'Regular vacation') { //vacation_type
            // deduct from vacation allocated            
            Employee::where('id', $employee_id)->update(['vacation_allocated' => ($vacation_allocated - $this->getDaysCount())]);
        }
    }

    private function getDaysCount()
    {
        // get count of days between two dates---
        $datetime1 = new DateTime(request('from_date'));
        $datetime2 = new DateTime(request('to_date'));
        $interval = $datetime1->diff($datetime2);

        return $interval->invert == 0 ? $interval->format('%a') + 1 : 'invalid'; //now do whatever you like with $days
    }

    private function InsertVacationPeriod($vacation, $employee_id)
    {
        $to_date = date('Y-m-d', strtotime(request('to_date') . ' + 1 day'));
        $period = new DatePeriod(
            new DateTime(request('from_date')),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );

        foreach ($period as $date_vacation) {
            VacationPeriod::firstOrCreate([
                'date_vacation' => $date_vacation,
                'employee_id'   => $employee_id,
                'vacation_id'   => $vacation->id,
                'vacation_type' => request('vacation_type'),
            ]);
        }
    }

    public function loans()
    {
        return view('staff::teacher.loans');
    }

    public function deductions()
    {
        return view('staff::teacher.deductions');
    }

    public function payrolls()
    {
        return view('staff::teacher.payrolls');
    }

    public function attendance()
    {
        return view('staff::teacher.attendance');
    }

    public function account()
    {
        return view('staff::teacher.account');
    }

    public function password()
    {
        return view('staff::teacher.password');
    }
}
