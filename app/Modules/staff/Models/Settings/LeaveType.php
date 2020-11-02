<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = "leave_types";
    protected $fillable = [
        'ar_leave',
        'en_leave',
        'have_balance',
        'activation',
        'target',
        'deduction',
        'deduction_allocated',
        'from_day',
        'to_day',
        'period',
        'sort',
        'admin_id'
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
    public function getTargetAttribute()
    {
        return $this->attributes['target'] == 'late' ? trans('staff::local.late') : trans('staff::local.early');
    }
    public function getActivationAttribute()
    {
        return $this->attributes['activation'] == 'active' ? trans('staff::local.active') : trans('staff::local.inactive');
    }
    public function getHaveBalanceAttribute()
    {
        return $this->attributes['have_balance'] == 'yes' ? trans('staff::local.yes') : trans('staff::local.no');
    }
    public function setEnLeaveAttribute($value)
    {
        return $this->attributes['en_leave'] = ucfirst($value);
    }
}
