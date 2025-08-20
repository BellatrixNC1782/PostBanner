<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserNotification;
use DB;
use JWTAuth;
use Auth;
use App\Models\Common;

class NotificationController extends Controller
{
    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    
    /*******************   START : Text notification on/off toggle    ********************/
    public function notificationOnOff(Request $request) {
        $message = array(
            'type.required' => 'Please select type',
            'type.in' => 'Please select any option from type',
            'is_notify.required' => 'Please select is notify',
            'is_notify.in' => 'Please select valid is notify',
        );
        $rules = array(
            'type' => 'required|in:push_notify',
            'is_notify' => 'required|boolean'
        );
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        $alert_update = User::find(Auth::User()->id);
        
        if($request->is_notify == true) {
            $alert_update->push_notify = 'Yes';
        } else {
            $alert_update->push_notify = 'No';
        }
        if ($alert_update->save()) {
            return response()->json(['message'=>'Notification Updated Successfully'], $this->successStatus);
        }
        return response()->json(['message' => 'Something went wrong'], $this->internalServer);
    }
    /*******************   END : Text notification on/off toggle    ********************/
    
    /*******************   START : Notification list for user    ********************/
    public function notificationlist(Request $request)
    {
        $offset = 0;
        $limit = 10;
        if (isset($request->offset)) {
            $offset = $request->offset;
        }
        if (isset($request->limit)) {
            $limit = $request->limit;
        }
        DB::table('user_notifications')
            ->where('send_id', Auth::User()->id)
            ->update(['is_read' => 1]);
        
        $UserNotification = UserNotification::select('users.user_name', 'users.image', 'user_notifications.message_test as message','user_notifications.display_flag', 
            'user_notifications.display_type', 'user_notifications.redirect_key', 'user_notifications.created_at as notification_date')
            ->join('users', 'users.id', '=', 'user_notifications.from_id')
            ->where('send_id', Auth::User()->id)
            ->orderBy('user_notifications.created_at', 'DESC');
        
        $total_notification = $UserNotification->count();
        $user_notification = $UserNotification->skip($offset)->take($limit)->get();

        if ($user_notification->isEmpty()) {
            return response()->json(['message' => 'No Notification found', 'data' => $user_notification], $this->successStatus);
        }
        foreach ($user_notification as $key => $value) {
            $user_notification[$key]->image = "";
        }

        return response()->json(['total_count' => $total_notification, 'data' => $user_notification], $this->successStatus);
    }
    /*******************   END : Notification list for user    ********************/
    
    /*******************   START : Un read notification count   ********************/
    public function unreadCount() { 
        $user_id = Auth::User()->id;
        try {
            //unread notification
            $unread_notification_count  = UserNotification::where('is_read',0)->where('send_id',$user_id)->count();
                   
            return response()->json(['unread_notification' => $unread_notification_count], $this->successStatus);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : Un read notification count   ********************/

}
