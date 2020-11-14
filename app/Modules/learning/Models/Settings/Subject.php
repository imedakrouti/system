<?php

namespace Learning\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'ar_name',
        'en_name',
        'sort',
        'image',
        'division_id',
        'grade_id',
        'admin_id',
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
    public function division()
    {
        return $this->belongsTo('Student\Models\Settings\Division','division_id')->orderBy('sort','asc');
    }
    public function grade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id')->orderBy('sort','asc');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
