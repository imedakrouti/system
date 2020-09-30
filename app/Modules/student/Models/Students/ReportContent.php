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
        'proof_enrollment', 
        'admin_id'
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
