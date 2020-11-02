<?php
namespace Student\Models\Guardians;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $table= 'guardians';
    protected $fillable = 
    [
        'guardian_full_name' ,   
        'guardian_guardian_type' ,   
        'guardian_mobile1' ,
        'guardian_mobile2' ,     
        'guardian_id_type' ,
        'guardian_id_number' ,        
        'guardian_email' ,
        'guardian_job' ,        
        'guardian_block_no' ,
        'guardian_street_name' ,
        'guardian_state' ,
        'guardian_government' ,     
        'admin_id'        
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
    public function getGuardianIdTypeAttribute()
    {
        return $this->attributes['guardian_id_type'] == 'national_id' ? trans('student::local.national_id'):
        trans('student::local.passport');
    }
    public function students()
    {
        return $this->hasMany('Student\Models\Students\Student','guardian_id');
    }
}
