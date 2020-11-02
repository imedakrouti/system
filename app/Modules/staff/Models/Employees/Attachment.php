<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'document_name',
        'file_name',      
        'employee_id',          
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
    public function employee()
    {
        return $this->belongsTo('Staff\Models\Employees\Employee','employee_id');
    }
}
