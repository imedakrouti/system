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
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
}
