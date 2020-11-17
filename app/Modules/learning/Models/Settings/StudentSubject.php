<?php

namespace Learning\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    protected $table = 'student_subject';

    protected $fillable = [
        'student_id' , 'subject_id' , 'admin_id'
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    } 
}
