<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'student_address';
    protected $fillable = [
        'student_id',
        'full_address',      
        'admin_id'

    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
