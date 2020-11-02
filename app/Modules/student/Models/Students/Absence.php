<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $table = 'absences';
    protected $fillable = [
        'absence_date',
        'status',      
        'student_id',  
        'notes',    
        'admin_id'

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
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 'absence' ? trans('student::local.absent') : trans('student::local.permit');
    }
}
