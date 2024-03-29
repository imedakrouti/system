<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class VacationPeriod extends Model
{
    protected $table = 'vacation_periods';
    protected $fillable = [
        'date_vacation',
        'vacation_type',
        'employee_id',
        'vacation_id'
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function employee()
    {
        return $this->belongsTo('Staff\Models\Employees\Employee','employee_id');
    }
    public function vacation()
    {
        return $this->belongsTo('Staff\Models\Employees\Vacation','vacation_id');
    }
}
