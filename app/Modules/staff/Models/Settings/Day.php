<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $fillable = ['ar_day','en_day','sort'];

    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
