<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Commissioner extends Model
{
    protected $table = 'commissioners';
    protected $fillable = [
        'commissioner_name',
        'id_number',      
        'mobile',      
        'notes',      
        'file_name',      
        'relation',              
        'admin_id',

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
    public function getRelationAttribute()
    {
        return $this->attributes['relation'] == 'relative' ? trans('student::local.relative') : trans('student::local.driver');
    }   
    public function students()
    {        
        return $this->belongsToMany('Student\Models\Students\Student','students_commissioners','commissioner_id','student_id')
        ->orderBy('father_id')->orderBy('mother_id')->orderBy('division_id')->orderBy('grade_id');
    }         
}
