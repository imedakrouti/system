<?php

namespace Staff\Models\Settings;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = ['arabicSector','englishSector','sort','admin_id'];

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
