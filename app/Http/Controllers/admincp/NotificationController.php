<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class NotificationController extends Controller {

    public $data = [];

    public function index() {
        return view('admincp.notifications.notification');
    }

    public function addNotification() {
        return view('admincp.notifications.addNotification', $this->data);
    }

    public function getNotification(Request $request) {
        $columns = array('id', 'alias', 'content', 'created_at', 'updated_at');
        $getfiled = array('id', 'alias', 'content', 'created_at');
        $condition = array();
        $join_str = array();
        echo Notifications::getNotificationModel('notifications', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function saveNotification(Request $request) {
        $messages = array(
            'title.required' => 'Please enter title',
            'title.min' => 'Please enter valid title',
            'title.max' => 'Please enter title in 32 character',
            'content.required' => 'Please enter content',
            'content.min' => 'Please enter valid content',
            'content.max' => 'Please enter content in :max',
        );
        $rules = array(
            'title' => 'required|min:3|max:200',
            'content' => 'required|min:3|max:5000',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        $is_alias_exist = Notifications::where('alias', str_replace(" ", "_", strtolower($request->title)))->get();
        if (!$is_alias_exist->isEmpty()) {
            return redirect()->back()->with('error', 'Alias already exist')->withInput();
        }
        DB::beginTransaction();
        try {
            $save_notification = new Notifications();
            $save_notification->alias = str_replace(" ", "_", strtolower($request->title));
            $save_notification->content = $request->content;
            $save_notification->title = $request->title;
            $save_notification->redirectid = $request->redirectid;
            $save_notification->diplink_id = $request->diplink_id;
            
            $save_notification->save();
            DB::commit();
            return redirect()->route('notification')->with('success', 'Notification added successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editNotification(Request $request, $id) {
        if ($id == "") {
            return redirect()->back()->with('error', 'Something went wrong.please try again');
        }
        $notification_deatil = Notifications::find($id);
        if (!$notification_deatil) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['edit_data'] = $notification_deatil;
        return view('admincp.notifications.editNotification', $this->data);
    }

    public function updateNotification(Request $request) {
        $messages = array(
            'title.required' => 'Please enter title',
            'content.min' => 'Please enter valid content',
            'content.max' => 'Please enter content in :max',
        );
        $rules = array(            
            'title' => 'required|min:3|max:200',
            'content' => 'required|min:3|max:5000',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        $is_alias_exist = Notifications::where('alias', str_replace(" ", "_", strtolower($request->title)))->where('id', '!=', $request->notification_id)->get();
        if (!$is_alias_exist->isEmpty()) {
            return redirect()->back()->with('error', 'Alias already exist')->withInput();
        }
        DB::beginTransaction();
        try {
            $update_notification = Notifications::find($request->notification_id);
            if (!$update_notification) {
                return redirect()->back()->with('error', 'Information not found');
            }
            $update_notification->content = $request->content;
            $update_notification->title = $request->title;
            $update_notification->redirectid = $request->redirectid;
            $update_notification->diplink_id = $request->diplink_id;    
            
            $update_notification->save();
            DB::commit();
            return redirect()->route('notification')->with('success', 'Notification updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong.please try again.');
        }
    }

    public function deleteModalNotification(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $settingDetail = Notifications::find(base64_decode($id));
            if (!$settingDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $settingDetail;
            $html = view('admincp.notifications.deleteModalNotification', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function deleteNotification(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->deleteId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $settingDetail = Notifications::find(base64_decode($request->deleteId));
            if (!$settingDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if (Notifications::find(base64_decode($request->deleteId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Notification deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

}
