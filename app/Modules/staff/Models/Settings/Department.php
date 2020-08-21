<?php

namespace Staff\Models\Settings;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['arabicDepartment','englishDepartment','balanceDepartmentLeave','sort','sector_id','admin_id'];

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
