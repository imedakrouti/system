<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;

use Learning\Models\Learning\ZoomAccount;

class ZoomAccountController extends Controller
{
    public function zoomAccount()
    {
        $account = ZoomAccount::where('admin_id', authInfo()->id)->first();
        $title = trans('learning::local.virtual_classrooms');
        return view(
            'learning::teacher.virtual-classrooms.zoom-account',
            compact('title', 'account')
        );
    }

    private function attributes()
    {
        return [
            'employee_id',
            'admin_id',
            'meeting_id',
            'pass_code'
        ];
    }

    public function storeZoomAccount()
    {
        $account = ZoomAccount::where('admin_id', authInfo()->id)->first();

        if ($account !== null) {
            $account->update(request()->only($this->attributes()));
        } else {
            request()->user()->zoomAccounts()->firstOrCreate(request()->only($this->attributes()));
        }
        toast(trans('learning::local.updated_zoom_account'), 'success');
        return redirect()->route('zoom.account');
    }
}
