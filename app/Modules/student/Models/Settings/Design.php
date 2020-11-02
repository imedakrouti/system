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
        'default_design',   
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
}
