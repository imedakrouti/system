<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class StageGrade extends Model
{
    protected $table = 'stage_grades';

    protected $fillable = ['stage_id','grade_id','admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function grade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id');
    }   
    public function stage()
    {
        return $this->belongsTo('Student\Models\Settings\Stage','stage_id');
    }      
}
