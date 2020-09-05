<?php

namespace Student\Models\Admissions;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class AdmissionReport extends Model
{
    protected $table="admission_reports";

    protected $fillable = [
        'report_title','student_id','father_id','report','admin_id'
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function fathers()
    {
        return $this->belongsTo('Student\Models\Parents\Father','father_id');
    }
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }  
    public function scopeParents($query)
    {
        return $query->whereNull('student_id');
    }  
    public function scopeStudents($query)
    {
        return $query->whereNull('father_id');
    } 
}
