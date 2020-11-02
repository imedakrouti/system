<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['school_name','school_government','school_address','school_type','admin_id'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function getSchoolTypeAttribute()
    {
        switch ($this->attributes['school_type']) {
            case 'private':
                return trans('student::local.private');
                break;
            case 'lang':
                return trans('student::local.lang');
                break;
            default:
                return trans('student::local.international');
                break;
        }
         
    }
}
