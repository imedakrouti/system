<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'name','username', 'email', 'password','lang','domain_role','ar_name','image_profile'
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

    public function studentUser()
    {
        return $this->hasOne('Student\Models\Students\Student','user_id');
    }
    public function fatherUser()
    {
        return $this->hasOne('Student\Models\Parents\Father','user_id');
    }
    public function username()
    {
        return 'username';
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 'enable' ? trans('admin.active') : trans('admin.inactive');
    }
    public function comments()
    {
        return $this->hasMany('Learning\Models\Learning\Comment','user_id');
    }
    public function userAnswers()
    {
        return $this->hasMany('Learning\Models\Learning\UserAnswer','user_id');
    }
    public function userExam()
    {
        return $this->hasMany('Learning\Models\Learning\UserExam','user_id');
    }
    public function lessonUser()
    {
        return $this->hasMany('Learning\Models\Learning\LessonUser','user_id');
    }
    public function zoomAttendances()
    {
        return $this->hasMany('Learning\Models\Learning\ZoomAttendance','user_id');
    }
    public function deliverHomework()
    {
        return $this->hasMany('Learning\Models\Learning\DeliverHomework','user_id');
    }
}
