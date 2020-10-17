<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['ar_holiday','en_holiday','description','sort','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function setEnHolidayAttribute($value)
    {
        return $this->attributes['en_holiday'] = ucfirst($value);
    }
}
