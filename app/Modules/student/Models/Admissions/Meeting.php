<?php

namespace Student\Models\Admissions;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'father_id',        
        'interview_id',        
        'start',
        'end',
        'meeting_status',
        'notes',        
        'admin_id',
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function fathers()
    {
        return $this->belongsTo('Student\Models\Parents\Father','father_id');
    }
    public function interviews()
    {
        return $this->belongsTo('Student\Models\Settings\Interview','interview_id');
    }
    public function getMeetingStatusAttribute()
    {
        $status = '';
        switch ($this->attributes['meeting_status']) {
            case 'pending':
                return $status = trans('student::local.meeting_pending');
                break;
            case 'canceled':
                return $status = trans('student::local.meeting_canceled');
                break;
            default:
                return $status = trans('student::local.meeting_done');
                break;
        }
    }
}
