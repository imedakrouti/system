<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';
    protected $fillable = [
        'student_id',
        'reason',
        'notes',
        'parent_type',        
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
    public function getParentTypeAttribute()
    {
        $parent_type = '';
        switch ($this->attributes['parent_type']) {
            case 'father':
                $parent_type = trans('student::local.father');
                break;
            case 'mother':
                $parent_type = trans('student::local.mother');
                break;
                            
            default:
                $parent_type = trans('student::local.others');
                break;
        }
        return  $parent_type;
    }
}
