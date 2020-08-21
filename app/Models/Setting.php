<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'id',
        'siteNameArabic',
        'siteNameEnglish',
        'logo',
        'icon',
        'email',
        'address',
        'contact',
        'openTime',
        'closeTime',
        'facebook',
        'youtube',
        'arabicDescription',
        'englishDescription',
        'keywords',
        'status',
        'messageMaintenance'
    ];

    public function users()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
