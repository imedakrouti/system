<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\Sector;

class Admin extends Authenticatable
{

    use Notifiable;
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password','image_profile','lang','status','adminGroupId','ar_name','domain_role'
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
    public function getDomainRoleAttribute()
    {
        switch ($this->attributes['domain_role']) {
            case 'super admin': return trans('staff::local.super_admin');
            case 'manager': return trans('staff::local.manager');
            case 'super visor': return trans('staff::local.super_visor');
            case 'staff': return trans('staff::local.staff');                           
            case 'owner': return trans('staff::local.owner');                           
            case 'teacher': return trans('staff::local.teacher');                           
            case 'none': return trans('staff::local.none_role');                           
        }        
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
    public function machines()
    {
        return $this->hasMany('Staff\Models\Settings\Machine','admin_id');
    }  
    public function externalCodes()
    {
        return $this->hasMany('Staff\Models\Settings\ExternalCode','admin_id');
    }       
    public function salaryComponents()
    {
        return $this->hasMany('Staff\Models\Settings\SalaryComponent','admin_id');
    }  
    public function timetables()
    {
        return $this->hasMany('Staff\Models\Settings\Timetable','admin_id');
    }   
    public function employees()
    {
        return $this->hasMany('Staff\Models\Employees\Employee','admin_id');
    }    
    public function attachments()
    {
        return $this->hasMany('Staff\Models\Employees\Attachment','admin_id');
    }    
    public function loans()
    {
        return $this->hasMany('Staff\Models\Employees\Loan','admin_id');
    }   
    public function deductions()
    {
        return $this->hasMany('Staff\Models\Employees\Deduction','admin_id');
    }   
    public function vacations()
    {
        return $this->hasMany('Staff\Models\Employees\Vacation','admin_id');
    }  
    public function leavePermissions()
    {
        return $this->hasMany('Staff\Models\Employees\LeavePermission','admin_id');
    }
    public function employeeUser()
    {
        return $this->hasOne('Staff\Models\Employees\Employee','user_id');
    }
    public function attendanceSheet()
    {
        return $this->hasMany('Staff\Models\Employees\AttendanceSheet','admin_id');
    }
    public function temporaryComponent()
    {
        return $this->hasMany('Staff\Models\Payrolls\TemporaryComponent','admin_id');
    }
    public function fixedComponent()
    {
        return $this->hasMany('Staff\Models\Payrolls\FixedComponent','admin_id');
    }
    public function payrollSheet()
    {
        return $this->hasMany('Staff\Models\Payrolls\PayrollSheet','admin_id');
    }
    public function payrollSheetEmployee()
    {
        return $this->hasMany('Staff\Models\Payrolls\PayrollSheetEmployee','admin_id');
    }
    public function payrollComponent()
    {
        return $this->hasMany('Staff\Models\Payrolls\PayrollComponent','admin_id');
    }
    public function internalRegulation()
    {
        return $this->hasMany('Staff\Models\Employees\InternalRegulation','admin_id');
    }
    public function announcements()
    {
        return $this->hasMany('Staff\Models\Employees\Announcement','admin_id');
    }
    public function subjects()
    {
        return $this->hasMany('Learning\Models\Settings\Subject','admin_id');
    }
    public function teacherSubject()
    {
        return $this->hasMany('Learning\Models\Settings\EmployeeSubject','admin_id');
    }
    public function teacherClasses()
    {
        return $this->hasMany('Learning\Models\Settings\EmployeeClassroom','admin_id');
    }
    public function studentSubject()
    {
        return $this->hasMany('Learning\Models\Settings\StudentSubject','admin_id');
    }
    public function lessons()
    {
        return $this->hasMany('Learning\Models\Learning\Lesson','admin_id');
    }
    public function lessonFiles()
    {
        return $this->hasMany('Learning\Models\Learning\LessonFile','admin_id');
    }
    public function playlists()
    {
        return $this->hasMany('Learning\Models\Learning\Playlist','admin_id');
    }
    public function exams()
    {
        return $this->hasMany('Learning\Models\Learning\Exam','admin_id');
    }
    public function questions()
    {
        return $this->hasMany('Learning\Models\Learning\Question','admin_id');
    }
    public function answers()
    {
        return $this->hasMany('Learning\Models\Learning\Answer','admin_id');
    }
    public function matchings()
    {
        return $this->hasMany('Learning\Models\Learning\Matching','admin_id');
    }
    public function posts()
    {
        return $this->hasMany('Learning\Models\Learning\Post','admin_id');
    }
}
