<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class StudentStatement extends Model
{
    protected $table = 'students_statements';
    protected $fillable = [
        'dd',
        'mm',      
        'yy',      
        'student_id',      
        'grade_id',      
        'division_id',      
        'year_id',      
        'registration_status_id',      
        'admin_id',

    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function student()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id')
        ->orderBy('gender','desc')->orderBy('ar_student_name','asc');
    }
    public function regStatus()
    {
        return $this->belongsTo('Student\Models\Settings\RegistrationStatus','registration_status_id');
    }
    public function division()
    {
        return $this->belongsTo('Student\Models\Settings\Division','division_id');
    }
    public function grade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id');
    }
    public function year()
    {
        return $this->belongsTo('Student\Models\Settings\Year','year_id');
    }
}
