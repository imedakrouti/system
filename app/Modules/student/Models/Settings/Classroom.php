<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'id',
        'ar_name_classroom',
        'en_name_classroom',
        'division_id',   
        'grade_id',   
        'year_id',   
        'sort',   
        'total_students',
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
    public function division()
    {
        return $this->belongsTo('Student\Models\Settings\Division','division_id');
    }
    public function grade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id');
    }
    public function year()
    {
        return $this->belongsTo('Student\Models\Settings\Year','year_id');
    }            
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function employees()
    {        
        return $this->belongsToMany('Staff\Models\Employees\Employee','employee_classroom','classroom_id','employee_id');
    }
    public function getClassNameAttribute()
    {
        return session('lang') == 'ar' ? $this->ar_name_classroom : $this->en_name_classroom;
    }

}
