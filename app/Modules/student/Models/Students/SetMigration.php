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
