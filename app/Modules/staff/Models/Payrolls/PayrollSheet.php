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
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
