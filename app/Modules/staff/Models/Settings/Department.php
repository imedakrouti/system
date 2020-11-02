<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['ar_department','en_department','sector_id','sort','leave_allocate','admin_id'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);        
    }
    public function setEnDepartmentAttribute($value)
    {
        return $this->attributes['en_department'] = ucfirst($value);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
