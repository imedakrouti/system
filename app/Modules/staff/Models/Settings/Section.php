<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['ar_section','en_section','sort','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
