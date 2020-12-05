<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class InternalRegulation extends Model
{
    protected $table = "internal_regulations";

    protected $fillable = ['internal_regulation_text','en_internal_regulation'];

    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
