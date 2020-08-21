<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['section','history','crud','user_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
