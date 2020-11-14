<?php

namespace Learning\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    protected $table = "teacher_subjects";

    protected $fillable = [
        'employee_id' , 'subject_id' , 'admin_id'
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
    public function employee()
    {
        return $this->belongsTo('Staff\Models\Employees\Employee','employee_id');
    }
    public function subject()
    {
        return $this->belongsTo('Learning\Models\Settings\Subject','subject_id');
    }
}
