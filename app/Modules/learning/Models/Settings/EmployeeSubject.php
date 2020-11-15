<?php

namespace Learning\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class EmployeeSubject extends Model
{
    protected $table = "employee_subject";

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

}
