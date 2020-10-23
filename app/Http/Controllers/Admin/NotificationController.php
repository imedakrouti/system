<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function userNotifications()
    {
        if (request()->ajax()) {            
            $count = '';            
            $notifications = '';
            $view = '';

            // count notification
                if(auth()->user()->unreadNotifications->count() != 0){
                    $count = '<i class="ficon ft-bell"></i>
                    <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow"> '.auth()->user()->unreadNotifications->count().'</span>';
                }else{
                    $count = '<i class="ficon ft-bell"></i>
                    <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow"></span>';
                }
            // count notification

            // notifications
            
                foreach (auth()->user()->notifications as $notification) {  
                    $read = $notification->read_at==null?'<i class="btn btn-xs btn-danger fa fa-eye"></i>':'<i class=" btn btn-xs btn-success fa fa-check"></i>';                                       
                    $notifications .= '                             
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">'.$notification->data["title"].'</h6>                                                
                                                <p class="notification-text font-small-3 text-muted">'.$notification->data["data"].'</p>
                                                <small>
                                                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00"> '.$notification->created_at->isoFormat(' dddd, Do MMMM  YYYY, h:mm').'</time>
                                                </small>
                                            </div>
                                            </div>
                                        </a>
                                   ';
                }
            // notifications
        
            // view
                if (auth()->user()->unreadNotifications->count() != 0) {
                    $view = '<a class="dropdown-item text-muted text-center" href="'.route('view.notifications').'">
                            '. trans('admin.view_notification') .'                        
                            </a>';
                }else{                    
                    $view = '<a class="dropdown-item text-muted text-center" href="'.route('view.notifications').'">
                    '. trans('admin.no_new_notifications') .'                        
                    </a>';
                }  
            // view

            $data['count']          = $count;            
            $data['notifications']  = $notifications;
            $data['view']           = $view;
            
            return response()->json($data);
        }
    }

    public function viewNotifications()
    {
        return view('layouts.backEnd.notifications.view',['title'=>trans('admin.notifications')]);
    }

    public function delete()
    {
        auth()->user()->notifications()->delete();
        return back();
    }
    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back(); 
    }
}
