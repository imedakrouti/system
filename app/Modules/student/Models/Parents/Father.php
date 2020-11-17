<?php

namespace Student\Models\Parents;

use Illuminate\Database\Eloquent\Model;

class Father extends Model
{
    protected $fillable = 
    [
        'ar_st_name' ,
        'ar_nd_name' ,
        'ar_rd_name' ,
        'ar_th_name' ,
        'en_st_name' ,
        'en_nd_name' ,
        'en_rd_name' ,
        'en_th_name' ,
        'id_type' ,
        'id_number' ,
        'religion' ,
        'nationality_id' ,
        'home_phone' ,
        'mobile1' ,
        'mobile2' ,
        'email' ,
        'job' ,
        'qualification' ,
        'facebook' ,
        'whatsapp_number' ,
        'block_no' ,
        'street_name' ,
        'state' ,
        'government' ,
        'educational_mandate' ,
        'marital_status' ,
        'recognition' ,        
        'admin_id' ,
        'user_id' ,
        
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
    public function nationalities()
    {
        return $this->belongsTo('Student\Models\Settings\Nationality','nationality_id');
    }
    public function mothers()
    {
        return $this->belongsToMany('Student\Models\Parents\Mother','father_mother','father_id','mother_id');
    }
    public function getIdTypeAttribute()
    {
        return $this->attributes['id_type'] == 'national_id' ? trans('student::local.national_id'):
        trans('student::local.passport');
    }
    public function getEducationalMandateAttribute()
    {
        return $this->attributes['educational_mandate'] == 'father' ?trans('student::local.father') : trans('student::local.mother');
    }
    public function getMaritalStatusAttribute()
    {        
        switch ($this->attributes['marital_status']) {
            case 'married':
                return trans('student::local.married');
                break;
            case 'divorced':
                return trans('student::local.divorced');
                break;
            case 'separated':
                return trans('student::local.separated');
                break;                                                
            default:
                return trans('student::local.widower');
                break;
        }
    }
    public function getRecognitionAttribute()
    {        
        switch ($this->attributes['recognition']) {
            case 'facebook':
                return trans('student::local.facebook');
                break;
            case 'parent':
                return trans('student::local.parent');
                break;
            case 'street':
                return trans('student::local.street');
                break;                                                
            default:
                return trans('student::local.school_hub');
                break;
        }
    }
    public function students()
    {
        return $this->hasMany('Student\Models\Students\Student','father_id')->orderBy('dob','asc');
    }
    public function setEnStNameAttribute($value)
    {
        return $this->attributes['en_st_name'] = ucfirst($value);
    }
    public function setEnNdNameAttribute($value)
    {
        return $this->attributes['en_nd_name'] = ucfirst($value);
    }
    public function setEnRdNameAttribute($value)
    {
        return $this->attributes['en_rd_name'] = ucfirst($value);
    }
    public function setEnThNameAttribute($value)
    {
        return $this->attributes['en_th_name'] = ucfirst($value);
    }
}
