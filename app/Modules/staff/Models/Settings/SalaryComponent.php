<?php
namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    protected $table = 'salary_components';
    protected $fillable = [    
        'ar_item',
        'en_item',
        'formula',
        'description',
        'sort',
        'type',
        'registration',
        'calculate',
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
    public function setEnItemAttribute($value)
    {
        return $this->attributes['en_item'] = ucfirst($value);
    }
    public function getTypeAttribute()
    {
        return $this->attributes['type'] == 'fixed' ? trans('staff::local.fixed') : trans('staff::local.variable');
    }
    public function getRegistrationAttribute()
    {
        return $this->attributes['registration'] == 'employee' ? trans('staff::local.employee_calc') : trans('staff::local.payroll_calc');
    }
    public function getCalculateAttribute()
    {        
        $calc = '';
        switch ($this->attributes['calculate']) {
            case 'net':
                $calc = trans('staff::local.net_type');
                break;
            case 'earn':
                $calc = trans('staff::local.earn_type');
                break;
            case 'deduction':
                $calc = trans('staff::local.deduction_type');
                break;
            default:
                $calc = trans('staff::local.info_type');
                break;
        }
        return $calc;
    }
    public function scopeVariable($query)
    {
        return $query->where('type','variable');
    }
    public function scopeFixed($query)
    {
        return $query->where('type','fixed');
    }
    public function scopeEmployee($query)
    {
        return $query->where('registration','employee');
    }
    public function payrollComponent()
    {
        return $this->hasMany('Staff\Models\Payrolls\PayrollComponent','salary_component_id');
    }
    
}
