<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['ar_stage_name','en_stage_name','sort','admin_id','signature'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($q)
    {
        return $this->orderBy('sort','asc');
    }
}
