<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['ar_division_name','en_division_name','sort','admin_id','total_students','school_name'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
