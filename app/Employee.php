<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'attendanceId',
        'enEmployeeName',
        'enFatherName',
        'enGrandName',
        'enFamilyName',
        'arEmployeeName',
        'arFatherName',
        'arGrandName',
        'arFamilyName',
    ];
}
