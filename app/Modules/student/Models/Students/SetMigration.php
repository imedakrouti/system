<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class SetMigration extends Model
{
    protected $table = 'set_migration';
    protected $fillable = [
        'id',
        'from_grade_id',    
        'to_grade_id',    
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
    public function fromGrade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','from_grade_id');
    }
    public function toGrade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','to_grade_id');
    }
}
