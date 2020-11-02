<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class AcceptanceTest extends Model
{
    protected $table = 'acceptance_tests';
    
    protected $fillable = 
    [
        'ar_test_name',
        'en_test_name',
        'grade_id',
        'sort',
        'admin_id'
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function grades()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
}
