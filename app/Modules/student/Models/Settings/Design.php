<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'id',
        'design_name',        
        'division_id',   
        'grade_id',   
        'admin_id'
    ];

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
}
