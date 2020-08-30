<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = 
    [
        'ar_step',
        'en_step',
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
}
