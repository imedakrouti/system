<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $fillable = 
    [
        'id',
        'ar_grade_name',
        'en_grade_name',
        'ar_grade_parent',
        'en_grade_parent',
        'from_age_year',
        'from_age_month',
        'to_age_year',
        'to_age_month',
        'sort',
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
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function designs()
    {
        return $this->hasMany('Student\Models\Settings\Design','grade_id');
    }
    public function fromMigration()
    {
        return $this->hasMany('Student\Models\Students\SetMigration','from_grade_id');
    }
}
