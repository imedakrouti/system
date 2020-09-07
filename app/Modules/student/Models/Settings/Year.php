<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['name','start_from','end_from','status','admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 'current' ? trans('student::local.current') : trans('student::local.not_current');
    }
    public function scopeCurrent($q)
    {
        return $q->where('status','current');
    }
}
