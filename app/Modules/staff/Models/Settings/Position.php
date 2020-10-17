<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['ar_position','en_position','sort','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function setEnPositionAttribute($value)
    {
        return $this->attributes['en_position'] = ucfirst($value);
    }
}
