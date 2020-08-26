<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $fillable = [
        'id',
        'ar_name_nat_male',
        'ar_name_nat_female',
        'en_name_nationality',
        'sort',   
        'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
