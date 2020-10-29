<?php

namespace Staff\Models\Payrolls;

use Illuminate\Database\Eloquent\Model;

class PayrollSheet extends Model
{
    protected $table = 'payroll_sheets';
    protected $fillable = [
        'ar_sheet_name',
        'en_sheet_name',
        'from_day',
        'to_day',
        'end_period',
        'code',
        'admin_id',
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
