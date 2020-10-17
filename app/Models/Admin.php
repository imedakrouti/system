<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\Sector;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password','image_profile','lang','status','adminGroupId'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function username()
    {
        return 'username';
    }
    public function settings()
    {
        $this->hasOne(Setting::class);
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 'enable' ? trans('admin.active') : trans('admin.inactive');
    }
    public function getLangAttribute()
    {
        return $this->attributes['lang'] == 'en' ? trans('admin.en') : trans('admin.ar');
    }
    public function getUsernameAttribute($value)
    {
        return $this->attributes['username'] = $value;
    }
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::created(function ($admin){
            // history('system','store',$admin->username .' has been stored');
        });

        static::updated(function ($admin){
            // history('system','update',$admin->username .' has been updated');
        });

        static::deleted(function ($admin){
            // history('system','destroy',$admin->username .' has been deleted');

        });
    }
    public function years()
    {
        return $this->hasMany('Student\Models\Settings\Year','admin_id');
    }
    public function divisions()
    {
        return $this->hasMany('Student\Models\Settings\Division','admin_id');
    }
    public function grades()
    {
        return $this->hasMany('Student\Models\Settings\Grade','admin_id');
    }
    public function admissionDocuments()
    {
        return $this->hasMany('Student\Models\Settings\AdmissionDoc','admin_id');
    }
    public function steps()
    {
        return $this->hasMany('Student\Models\Settings\Step','admin_id');
    }
    public function acceptanceTest()
    {
        return $this->hasMany('Student\Models\Settings\AcceptanceTest','admin_id');
    }
    public function documentGrades()
    {
        return $this->hasMany('Student\Models\Settings\DocumentGrade','admin_id');
    }
    public function registrationStatus()
    {
        return $this->hasMany('Student\Models\Settings\RegistrationStatus','admin_id');
    }
    public function nationalities()
    {
        return $this->hasMany('Student\Models\Settings\Nationality','admin_id');
    }
    public function interviews()
    {
        return $this->hasMany('Student\Models\Settings\Interview','admin_id');
    }
    public function languages()
    {
        return $this->hasMany('Student\Models\Settings\Language','admin_id');
    }
    public function classrooms()
    {
        return $this->hasMany('Student\Models\Settings\Classroom','admin_id');
    }
    public function designs()
    {
        return $this->hasMany('Student\Models\Settings\Design','admin_id');
    }
    public function fathers()
    {
        return $this->hasMany('Student\Models\Parents\Father','admin_id');
    }
    public function mothers()
    {
        return $this->hasMany('Student\Models\Parents\Mother','admin_id');
    }
    public function schools()
    {
        return $this->hasMany('Student\Models\Settings\School','admin_id');
    }
    public function guardians()
    {
        return $this->hasMany('Student\Models\Guardians\Guardian','admin_id');
    }
    public function students()
    {
        return $this->hasMany('Student\Models\Students\Student','admin_id');
    }
    public function medicals()
    {
        return $this->hasMany('Student\Models\Students\Medical','admin_id');
    }
    public function contacts()
    {
        return $this->hasMany('Student\Models\Parents\Contact','admin_id');
    }
    public function meetings()
    {
        return $this->hasMany('Student\Models\Admissions\Meeting','admin_id');
    }
    public function reports()
    {
        return $this->hasMany('Student\Models\Admissions\AdmissionReport','admin_id');
    }
    public function scopeActive($q)
    {
        return $q->where('status','enable');
    }
    public function employees()
    {
        return $this->hasMany('Student\Models\Students\Student','employee_id');
    }
    public function assessments()
    {
        return $this->hasMany('Student\Models\Admissions\Assessment','admin_id');
    }
    public function statements()
    {
        return $this->hasMany('Student\Models\Students\StudentStatement','admin_id');
    }
    public function setMigration()
    {
        return $this->hasMany('Student\Models\Students\SetMigration','admin_id');
    }
    public function stages()
    {
        return $this->hasMany('Student\Models\Settings\Stage','admin_id');
    } 
    public function stageGrades()
    {
        return $this->hasMany('Student\Models\Settings\StageGrade','admin_id');
    } 
    public function commissioners()
    {
        return $this->hasMany('Student\Models\Students\Commissioner','admin_id');
    }     
    public function studentsCommissioners()
    {
        return $this->hasMany('Student\Models\Students\StudentCommissioner','admin_id');
    }   
    public function rooms()
    {
        return $this->hasMany('Student\Models\Students\Room','admin_id');
    }  
    public function leaveRequests()
    {
        return $this->hasMany('Student\Models\Students\LeaveRequest','admin_id');
    } 
    public function reportContent()
    {
        return $this->hasMany('Student\Models\Students\ReportContent','admin_id');
    }    
    public function transfers()
    {
        return $this->hasMany('Student\Models\Students\Transfer','admin_id');
    }    
    public function dailyRequests()
    {
        return $this->hasMany('Student\Models\Students\DailyRequest','admin_id');
    }  
    public function parentRequests()
    {
        return $this->hasMany('Student\Models\Students\ParentRequest','admin_id');
    }  
    public function notes()
    {
        return $this->hasMany('Student\Models\Students\Note','admin_id');
    }  
    public function absences()
    {
        return $this->hasMany('Student\Models\Students\Absence','admin_id');
    }  
    public function archives()
    {
        return $this->hasMany('Student\Models\Students\Archive','admin_id');
    }  
    public function sectors()
    {
        return $this->hasMany('Staff\Models\Settings\Sector','admin_id');
    }   
    public function departments()
    {
        return $this->hasMany('Staff\Models\Settings\Department','admin_id');
    } 
    public function sections()
    {
        return $this->hasMany('Staff\Models\Settings\Section','admin_id');
    }         
    public function positions()
    {
        return $this->hasMany('Staff\Models\Settings\Position','admin_id');
    }  
    public function documents()
    {
        return $this->hasMany('Staff\Models\Settings\Document','admin_id');
    }   
    public function skills()
    {
        return $this->hasMany('Staff\Models\Settings\Skill','admin_id');
    }  
    public function holidays()
    {
        return $this->hasMany('Staff\Models\Settings\Holiday','admin_id');
    }   
    public function holidayDays()
    {
        return $this->hasMany('Staff\Models\Settings\HolidayDay','admin_id');
    }     
    public function leaveTypes()
    {
        return $this->hasMany('Staff\Models\Settings\LeaveType','admin_id');
    }               
}
