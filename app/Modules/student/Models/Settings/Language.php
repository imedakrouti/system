<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'id',
        'ar_name_lang',
        'en_name_lang',
        'lang_type',
        'sort',   
        'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function scopeStudy($query)
    {
        return $query->where('lang_type','study')->orWhere('lang_type','speak_study');
    }
    public function getLangTypeAttribute()
    {
        switch ($this->attributes['lang_type']) {
            case 'speak':
                return trans('student::local.speak');
                break;
            case 'study':
                return trans('student::local.study');
                break;
            default:
                return trans('student::local.speak_study');
                break;
        }
         
    }
}
