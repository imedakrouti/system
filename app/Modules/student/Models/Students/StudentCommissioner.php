<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class StudentCommissioner extends Model
{
    protected $table = 'students_commissioners';
    protected $fillable = [
        'commissioner_id',             
        'student_id',             
        'admin_id',
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    } 
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }


   
}
