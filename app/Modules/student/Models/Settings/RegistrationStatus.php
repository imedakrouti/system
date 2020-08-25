<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model
{
    protected $table = 'registration_status';
    
    protected $fillable = 
    [
        'ar_name_status',
        'en_name_status',
        'description',
        'shown',
        'sort',
        'admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function getShownAttribute()
    {
        return $this->attributes['shown'] == 'show' ? trans('student::local.show_regg') : trans('student::local.hidden_reg');        
    }
}
