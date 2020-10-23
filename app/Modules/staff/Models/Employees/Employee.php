<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{

    use SoftDeletes;
    
    protected $fillable = [
        'attendance_id',
        'ar_st_name',
        'ar_nd_name',
        'ar_rd_name',
        'ar_th_name',
        'en_st_name',
        'en_nd_name',
        'en_rd_name',
        'en_th_name',
        'email',
        'mobile1',
        'mobile2',
        'dob',
        'gender',
        'address',
        'religion',
        'native',
        'marital_status',
        'health_details',
        'national_id',
        'military_service',
        'hiring_date',
        'job_description',
        'has_contract',
        'contract_type',
        'contract_date',
        'contract_end_date',
        'previous_experience',
        'institution',
        'qualification',
        'social_insurance',
        'social_insurance_num',
        'social_insurance_date',
        'medical_insurance',
        'medical_insurance_num',
        'medical_insurance_date',
        'exit_interview_feedback',
        'leave_date',
        'leave_reason',
        'leaved',
        'salary',
        'salary_suspend',
        'salary_mode',
        'salary_bank_name',
        'bank_account',
        'leave_balance',
        'bus_value',
        'vacation_allocated',        
        'sector_id',
        'department_id',
        'section_id',
        'position_id',
        'timetable_id',
        'direct_manager_id',            
        'admin_id',
        'user_id',
        'employee_image'
    ];

    public function admins()
    {
        return $this->belongsTo(App\Models\Admin::class);
    }
    public function employee_user()
    {
        return $this->belongsTo('App\Models\Admin','user_id');

    }
    public function timetable()
    {
        return $this->belongsTo('Staff\Models\Settings\Timetable','timetable_id');
    }
    public function sector()
    {
        return $this->belongsTo('Staff\Models\Settings\Sector','sector_id');
    }
    public function department()
    {
        return $this->belongsTo('Staff\Models\Settings\Department','department_id');
    }
    public function section()
    {
        return $this->belongsTo('Staff\Models\Settings\Section','section_id');
    }
    public function position()
    {
        return $this->belongsTo('Staff\Models\Settings\Position','position_id');
    }
    public function holidays()
    {
        return $this->belongsTo('Staff\Models\Settings\Holiday','holiday_id');
    }
    public function scopeLeaved($query)
    {
        return $query->where('leaved','Yes');
    }
    public function scopeWork($query)
    {
        return $query->where('leaved','No');
    }

    public function setEnStNameAttribute($value)
    {
        return $this->attributes['en_st_name'] = ucfirst($value);
    }
    public function setEnNdNameAttribute($value)
    {
        return $this->attributes['en_nd_name'] = ucfirst($value);
    }
    public function setEnRdNameAttribute($value)
    {
        return $this->attributes['en_rd_name'] = ucfirst($value);
    }
    public function setEnThNameAttribute($value)
    {
        return $this->attributes['en_th_name'] = ucfirst($value);
    }
}
