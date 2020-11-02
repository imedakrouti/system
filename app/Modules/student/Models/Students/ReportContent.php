<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class ReportContent extends Model
{
    protected $table = 'report_contents';

    protected $fillable = [
        'student_id',
        'endorsement', 
        'daily_request', 
        'parent_request', 
        'proof_enrollment', 
        'statement_request', 
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
}
