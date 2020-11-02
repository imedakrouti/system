<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['ar_skill','en_skill','sort','admin_id'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function setEnSkillAttribute($value)
    {
        return $this->attributes['en_skill'] = ucfirst($value);
    }
}
