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
        
    ];
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
}
