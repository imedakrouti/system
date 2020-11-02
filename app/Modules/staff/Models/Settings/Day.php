<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $fillable = ['ar_day','en_day','sort'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
