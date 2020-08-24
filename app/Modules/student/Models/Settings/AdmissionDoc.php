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
        'notes',
        'registration_type',
        'sort',
        'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function getRegistrationTypeAttribute()
    {
        switch ($this->attributes['registration_type']) {
            case 'new':
                return trans('student::local.new');
                break;
            case 'transfer':                
                return trans('student::local.transfer');
                break;
            case 'returning':                
                return trans('student::local.returning');
                break;                            
            default:
                return trans('student::local.arrival');            
                break;
        }
    }
}
