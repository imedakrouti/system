<?php

namespace Student\Models\Parents;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'relative_name',
        'relative_mobile',
        'relative_notes',
        'relative_relation',
        'father_id',
        'admin_id'
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function father()
    {
        return $this->belongsTo('Student\Models\Parents\Father','father_id');
    }
    public function getRelativeRelationAttribute()
    {
        switch ($this->attributes['relative_relation']) {
            case 'grand_pa':
                return trans('student::local.grand_pa');
                break;
            case 'grand_ma':
                return trans('student::local.grand_ma');
                break;
            case 'uncle':
                return trans('student::local.uncle');
                break;                                    
            case 'aunt':
                return trans('student::local.aunt');
                break;
            case 'neighbor':
                return trans('student::local.neighbor');
                break;     
            default:
                return trans('student::local.other');
                break;
        }
    }
}
