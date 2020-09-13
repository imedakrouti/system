<?php

namespace Student\Models\Admissions;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'assessment_id','test_id','test_result','employee_id','acceptance_test_id'
    ];
    public function assessment()
    {
        return $this->belongsTo('Students\Models\Admissions\Assessment','assessment_id');
    }
    public function acceptTest()
    {
        return $this->belongsTo('Student\Models\Settings\AcceptanceTest','acceptance_test_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }
    public function getTestResultAttribute()
    {        
        switch ( $this->attributes['test_result']) {
            case 'excellent':
                return trans('student::local.excellent');
                break;
            case 'very good':
                return trans('student::local.very_good');
                break;
            case 'good':
                return trans('student::local.good');
                break;                                
            default:
                return trans('student::local.weak');
                break;
        }
    }
}
