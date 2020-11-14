<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected  $table = 'announcements';
    protected $fillable = ['announcement','start_at','end_at','domain_role','admin_id'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function getDomainRoleAttribute()
    {
        switch ($this->attributes['domain_role']) {
            case 'super admin': return trans('staff::local.super_admin');
            case 'manager': return trans('staff::local.manager');
            case 'super visor': return trans('staff::local.super_visor');
            case 'staff': return trans('staff::local.staff');                           
            case 'owner': return trans('staff::local.owner');                           
            case 'teacher': return trans('staff::local.teacher');                           
            case 'none': return trans('staff::local.none_role');                           
        }        
    }
}
