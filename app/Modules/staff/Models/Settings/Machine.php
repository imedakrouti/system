<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = ['device_name','ip_address','port','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
