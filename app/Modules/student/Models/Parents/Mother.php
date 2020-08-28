<?php

namespace Student\Models\Parents;

use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    protected $fillable = 
    [
        'full_name' ,
        'id_type_m' ,
        'id_number_m' ,
        'home_phone_m' ,
        'mobile1_m' ,
        'mobile2_m' ,
        'job_m' ,
        'email_m' ,
        'qualification_m' ,
        'facebook_m' ,
        'whatsapp_number_m' ,
        'nationality_id_m' ,
        'religion_m' ,
        'block_no_m' ,
        'street_name_m' ,
        'state_m' ,
        'government_m' ,
        'admin_id_m' ,
        
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function nationalities()
    {
        return $this->belongsTo('Student\Models\Settings\Nationality','nationality_id_m');
    }
    public function fathers()
    {
        return $this->belongsToMany('Student\Models\Parents\Father','father_mother','mother_id','father_id');
    }
}
