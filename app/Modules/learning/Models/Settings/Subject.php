<?php

namespace Learning\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'ar_name',
        'ar_shortcut',
        'en_name',
        'en_shortcut',
        'sort',
        'image',                
        'admin_id',
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
