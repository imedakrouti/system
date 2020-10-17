<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['ar_skill','en_skill','sort','admin_id'];
    
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
