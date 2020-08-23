<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['name','start_from','end_from','admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
