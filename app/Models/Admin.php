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
        'name','username', 'email', 'password','image_profile','lang','status'
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
    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
