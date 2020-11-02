<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class HrReport extends Model
{
    protected $table = "hr_reports";
    protected $fillable = [
        'hr_letter',
        'employee_leave',
        'employee_experience',
        'employee_vacation',
        'employee_loan',
        'header',
        'footer',
        'admin_id',        
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
