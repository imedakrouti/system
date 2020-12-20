<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class AbsenceSession extends Model
{
    protected $table_name = 'absence_sessions';

    protected $fillable = [
        'absence_date',
        'notes',
        'status',        
        'student_id',                       
        'subject_id',
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
}
