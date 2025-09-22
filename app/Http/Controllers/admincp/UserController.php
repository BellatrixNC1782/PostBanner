<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Common;
use Validator;
use Hash;
use DB;
use Carbon\Carbon;
use Auth;

class UserController extends Controller {

    public $data = [];

    /********************   START : Get user list    *********************/
    public function userList(Request $request) {
        
        
        return view('admincp.user.user');
    }
    
    public function getUserList(Request $request) {
        $columns = array(
            'u.id',
            'u.user_name',
            'u.email',
            'u.mobile',
            'u.created_at',
            'u.status',
        );
        $getfiled = array(
            'u.id',
            'u.user_name',
            'u.email',
            'u.mobile',
            'u.created_at',
            'u.status',
        );
        $condition = array();
        $join_str = array();
      
        echo User::getUser('users as u', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    /********************   End : Get user list    *********************/

    /********************   START : Change user status    *********************/    
     public function changeUserStatus(Request $request, $id) {
        
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = User::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('admincp.user.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }
    
    public function updateUserStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->user_id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = User::find(base64_decode($request->user_id));
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if ($changeStatus->status == 'active') {
                $changeStatus->status = 'inactive';
            } else {
                $changeStatus->status = 'active';
            }
            if (!$changeStatus->save()) {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            return response()->json(['status' => 'success', 'message' => "Status change successfully"]);
        }
        exit;
    }
    /********************   End : Change user status    *********************/

    /********************   START : View user    *********************/
    public function viewUser(Request $request,$id) {
        
        $this->data['user_data'] = User::where('id',$id)->first();
        
        
       
        return view('admincp.user.viewuser', $this->data);
    }
    /********************   END : View user    *********************/
}
