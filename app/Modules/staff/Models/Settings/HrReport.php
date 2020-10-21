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
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
