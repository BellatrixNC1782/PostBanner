<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Notifications\webAdminEmailChange;
use Illuminate\Http\Request;
use App\Models\Common;
use Auth;
use App\Models\Admin;
use Session;
use DB;
use App\Mail\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class Profilecontroller extends Controller 
{

    public $data = [];
    
    public function index(Request $request) {
        $this->data['user_detail'] = Admin::find(Auth::guard('admin')->User()->id);

        return view('admincp.profile.profileform', $this->data);
    }

    public function updateprofile(Request $request) {

        $messages = array(
            'first_name.required' => 'Please enter an first name',
            'first_name.string' => 'Please enter only string',
            'first_name.min' => 'First name must conatin minimum 2 characters',
            'first_name.max' => 'First name must conatin maximum 32 characters',
            'last_name.required' => 'Please enter an last name',
            'last_name.string' => 'Please enter only string',
            'last_name.min' => 'Last name should be minimum :min characters',
            'last_name.max' => 'Last name must conatin maximum 32 characters',
            'email.required' => 'Please enter a email',
            'email.email' => 'Invalid Email Formate',
            'email.max' => 'Email must be 255 character',
            'number.required' => 'Please enter Phone number',
            'number.max' => 'Phone number must contains 10 character',
        );
        $rules = array(
            'first_name' => 'required|string|min:2|max:32',
            'last_name' => 'required|string|min:2|max:32',
            'email' => 'required|email|max:255',
            'number' => 'required|min:12|regex:/^\d{3}-\d{3}-\d{4}$/',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $user_detail = Admin::find(Auth::guard('admin')->User()->id);

        if (!$user_detail) {
            return redirect()->back()->with('error', 'Information not found.');
        } else {
                
            if ($request->hasFile('image')) {
                $result = Common::uploadSingleImage($request->image,'admin');

                if ($result['status'] == 0) {
                    return redirect()->back()->with('error', 'Result not found.');
                } else {
                    $user_detail->image = $result['data'];
                }
            }

            $user_detail->first_name = $request->first_name;
            $user_detail->last_name = $request->last_name;
            $user_detail->email = $request->email;
            $user_detail->number = str_replace('-', '', $request->number);
            $user_detail->updated_at = date('Y-m-d h:i:s');

            if ($user_detail->save()) {
                return redirect()->route('profile')->with('success', 'Profile updated successfully.');
            }
            return redirect()->back()->with('error', 'Something went wrong.please try again.');
        }
    }
    
    /*public function emailVerify(Request $request) {
        
        if(!empty(Auth::guard('admin')->User()->id)){
            Auth::guard('admin')->logout();
        }
        $checkToken = Admin::where('email_token',$request->varifylink)->first();
        
        if(empty($checkToken)){
            return redirect()->route('admincplogin')->with('error', 'Token is invalid!');
        }
        
        Admin::where('email_token',$request->varifylink)->update(array('email' => $checkToken->new_email,'new_email' => NULL,'email_token' => NULL));
        
        return redirect()->route('admincplogin')->with('success', 'Email updated successfully, please login using new email..!');
    }*/

}
