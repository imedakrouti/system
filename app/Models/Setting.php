<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'id',
        'ar_school_name',
        'en_school_name',
        'logo',
        'icon',
        'email',
        'address',
        'contact1',
        'contact2',
        'contact3',
        'open_time',
        'close_time',
        'fb',
        'yt',
        'status',
        'ar_education_administration',
        'en_education_administration',
        'msg_maintenance'
    ];

    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
