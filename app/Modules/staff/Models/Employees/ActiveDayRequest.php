<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class ActiveDayRequest extends Model
{
    protected $table = 'active_days_request';
    protected $fillable = [
        'working_day',
        'leave_type_id'        
    ];
}
