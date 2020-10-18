<?php
namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class ExternalCode extends Model
{
    protected $fillable = ['pattern','replacement','description','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
