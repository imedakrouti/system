<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class AdmissionDoc extends Model
{
    protected $table = 'admission_documents';

    protected $fillable = [
        'id',
        'ar_document_name',
        'en_document_name',
        'sort',
        'notes',
        'registration_type',
        'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function scopeSort($query)
    {
        return $query->orderBy('sort','asc');
    }
    public function docsGrade()
    {
        return $this->hasMany('Student\Models\Settings\DocumentGrade','admission_document_id');
    }
}
