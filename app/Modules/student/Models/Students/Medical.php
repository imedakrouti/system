<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    protected $table = 'medicals';
    protected $fillable = [
        'student_id',
        'blood_type',
        'food_sensitivity',
        'medicine_sensitivity',
        'other_sensitivity',
        'have_medicine',
        'vision_problem',
        'use_glasses',
        'hearing_problems',
        'speaking_problems',
        'chest_pain',
        'breath_problem',
        'asthma',
        'have_asthma_medicine',
        'heart_problem',
        'hypertension',
        'diabetic',
        'anemia',
        'cracking_blood',
        'coagulation',
        'admin_id'

    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function student()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }
}
