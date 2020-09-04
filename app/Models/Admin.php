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
}
