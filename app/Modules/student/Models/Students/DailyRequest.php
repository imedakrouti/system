<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class DailyRequest extends Model
{
    protected $table = 'daily_requests';
    protected $fillable = [        
        'leave_time',
        'recipient_name',
        'student_id',        
        'admin_id'

    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }
}
