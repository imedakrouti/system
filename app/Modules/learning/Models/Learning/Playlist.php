<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'playlist_name',
        'subject_id',
        'employee_id',        
        'sort',                       
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
    
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function employees()
    {
        return $this->belongsTo('Staff\Models\Employees\Employee','employee_id')->orderBy('attendance_id');
    }
    public function subjects()
    {
        return $this->belongsTo('Learning\Models\Settings\Subject','subject_id');
    }
    public function lessons()
    {
        return $this->hasMany('Learning\Models\Learning\Lesson','playlist_id');
    }
    public function classes()
    {
        return $this->belongsToMany('Student\Models\Settings\Classroom','playlist_classroom','playlist_id','classroom_id');
    }
}
