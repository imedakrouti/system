<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Behaviour extends Model
{
    protected $table = "behaviours";

    protected $fillable = [
        'behaviour_mark',
        'year_id',
        'student_id',
        'subject_id',
        'month_id',
        'admin_id',
        'classroom_id'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }
}
