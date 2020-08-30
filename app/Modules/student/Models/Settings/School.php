<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['school_name','school_government','school_address','school_type','admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function getSchoolTypeAttribute()
    {
        switch ($this->attributes['school_type']) {
            case 'speak':
                return trans('student::local.private');
                break;
            case 'study':
                return trans('student::local.lang');
                break;
            default:
                return trans('student::local.international');
                break;
        }
         
    }
}
