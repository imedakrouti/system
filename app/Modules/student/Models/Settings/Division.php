<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['ar_division_name','en_division_name',
    'sort','admin_id','total_students','ar_school_name','en_school_name'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function subjects()
    {        
        return $this->belongsToMany('Learning\Models\Settings\Subject','division_subject','division_id','subject_id');
    }
    

}
