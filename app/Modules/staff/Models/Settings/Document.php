<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['ar_document','en_document','sort','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
