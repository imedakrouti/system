<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'subject_id',
        'lesson_title',
        'description',
        'explanation',
        'sort',
        'visibility',
        'approval',                
        'video_url',                
        'file_name',  
        'playlist_id',           
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
    
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function divisions()
    {
        return $this->belongsToMany('Student\Models\Settings\Division','lesson_division','lesson_id','division_id');
    }
    public function grades()
    {
        return $this->belongsToMany('Student\Models\Settings\Grade','lesson_grade','lesson_id','grade_id');
    }
    public function years()
    {
        return $this->belongsToMany('Student\Models\Settings\Year','lesson_year','lesson_id','year_id');
    }

    public function subject()
    {
        return $this->belongsTo('Learning\Models\Settings\Subject','subject_id');
    }
    public function files()
    {
        return $this->hasMany('Learning\Models\Learning\LessonFile','lesson_id');
    }
    public function playlist()
    {
        return $this->belongsTo('Learning\Models\Learning\Playlist','playlist_id');
    }
}
