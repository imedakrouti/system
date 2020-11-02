<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class DocumentGrade extends Model
{
    protected $table = 'documents_grades';
    
    protected $fillable = 
    [
        'admission_document_id',        
        'grade_id',        
        'admin_id'
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
    public function grades()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id');
    }
    public function admissionDocuments()
    {
        return $this->belongsTo('Student\Models\Settings\AdmissionDoc','admission_document_id')->orderBy('sort','asc');
    }
}
