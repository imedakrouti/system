<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $fillable = 
    [
        'ar_grade_name',
        'en_grade_name',
        'ar_grade_parent',
        'en_grade_parent',
        'from_age_year',
        'from_age_month',
        'to_age_year',
        'to_age_month',
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
    public function designs()
    {
        return $this->hasMany('Student\Models\Settings\Design','grade_id');
    }
}
