<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'student_id',
        'classroom_id',        
        'year_id',
        'admin_id',
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }
    public function classrooms()
    {
        return $this->belongsTo('Student\Models\Settings\Classroom','classroom_id');
    }    
    public function years()
    {
        return $this->belongsTo('Student\Models\Settings\Year','year_id');
    }
    
}
