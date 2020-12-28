<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = "months";

    protected $fillable = ['ar_month_name', 'en_month_name'];

    public function getMonthNameAttribute()
    {
        return session('lang') == 'ar' ? $this->ar_month_name : $this->en_month_name;
    }
    public function behaviours()
    {
        return $this->hasMany('Learning\Models\Learning\Behaviour','month_id');
    }

}
