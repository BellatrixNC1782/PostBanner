<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Hash;

class ChangepasswordController extends Controller
{
    public $data = [];

    public function __construct() {
        $this->middleware('admincp');
    }
    
    public function updatepassword(Request $request) {
        $messsages = array(
            'c_password.required' => 'Please enter a current password',
            'n_password.required' => 'Please enter a new password',
            'n_password.min' => 'New password must contain atleast :min characters',
            'n_password.max' => 'New password must contain maximum :max characters',
            'n_password.different' => 'New password must be different from current password',
            'con_password.required' => 'Please enter a confirm password',
            'con_password.min' => 'Confirm password must contain atleast :min characters',
            'con_password.max' => 'Confirm password must contain maximum :max characters',
            'con_password.different' => 'Confirm password must be different from current password',
            'con_password.same' => 'Confirm password does not match',
        );
        $rules = array(
            'c_password' => 'required',
            'n_password' => 'required|min:6|max:24|different:c_password',
            'con_password' => 'required|min:6|max:24|same:n_password|different:c_password'
        );
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0]);
            }
        }
        $user_detail = Admin::find(Auth::guard('admin')->User()->id);
        
        if (!$user_detail) {
            return redirect()->back()->with('error', 'Information not found.');
        }
        else {
            if (!Hash::check($request->c_password, $user_detail->password)) {
                return redirect()->back()->with('error', 'Please enter a correct current password');
            }
            if ( Hash::check( $request->n_password, $user_detail->password ) ) {
                return redirect()->back()->with('error', 'New password can not be same as old password');
            }
            $user_detail->password = Hash::make($request->n_password);
            if($user_detail->save()){
                return redirect()->back()->with('success', 'Your password has been changed successfully');
            }
            return redirect()->back()->with('error', 'Something went wrong.please try again');
        }
    }
}
