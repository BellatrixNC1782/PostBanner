<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Common;
use App\Models\Admin;
use Auth;
use Hash;
use Session;
use App\Models\Settings;
use App\Mail\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AdminForgotpassword;
use App\Jobs\SendMailJob;

class LoginController extends Controller
{
    public $data = [];
    
    public function index(Request $request) {
        abort(404,'Page not found.');
                                
        if(isset($request->varifylink)){
            if(!empty(Auth::guard('admin')->User()->id)){
                Auth::guard('admin')->logout();
            }
            $checkToken = Admin::where('email_token',$request->varifylink)->first();

            if(empty($checkToken)){
                return redirect()->route('admincp')->with('error', 'Token is invalid!');
            }

            Admin::where('email_token',$request->varifylink)->update(array('email' => $checkToken->new_email,'new_email' => NULL,'email_token' => NULL));

            return redirect()->route('admincp')->with('success', 'Email updated successfully, please login using new email..!');
        }
        
        if (!Auth::guard('admin')->check()) {
            return view('admincp.login.index', $this->data);
        }
        return redirect()->route('dashboard');
    }
    
    public function admincplogout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admincp');
    }
    
    public function login(Request $request) {
        
        $messages = array(
            'email.required' => 'Please enter an email',
            'email.email' => 'Invalid Email',
            'password.required' => 'Please enter a password',
            'password.min' => 'Password must conatin atleast 6 characters',
            'password.max' => 'Password must conatin maximum 24 characters',
        );
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6|max:24',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        if (!empty(Session::get('requestEmail'))) {
            Session::forget('requestEmail');
        }
        $checkEmailExist = Admin::where('email',$request->email)->get();
        if ($checkEmailExist->isEmpty()) {
            return redirect()->back()->with('error', 'Email does not exist');
        }
        $remember_me = $request->has('remember') ? true : false;
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with('error', 'Email and password does not match')->withInput($request->all);
    }
    
    public function forgotpassword() {
        return view('admincp.forgotpassword.index');
    }

    public function sendforgotpassword(Request $request) {
        if (!empty(Session::get('requestEmail'))) {
            Session::forget('requestEmail');
        }
        if ($request->email == "" && !isset($request->email)) {
            return redirect()->back()->with('error', 'Please enter email address.');
        }
        Session::put('adminRequestEmail',$request->email);
        $checkEmailExist = Admin::where('email', '=', $request->email)->first();
        
        if (empty($checkEmailExist)) {
            return redirect()->back()->with('error', 'Email address does not exist.');
        }

        /* */
        $requestEmail = $request->email;
        //Session::put('variableName', '');
        Session::put('requestEmail', $requestEmail);

        $otp = Common::generateOtp()['user_otp'];
        $otp_expire = Common::generateOtp()['expire_time'];
        
        $checkEmailExist->msg_otp = $otp;
        $checkEmailExist->otp_expire_time = $otp_expire;
        $checkEmailExist->save();
        //$checkEmailExist->msg_otp = Common::generateOtp();
        $this->data['forgot_otp_number'] = $checkEmailExist->msg_otp;
        $this->data['first_name'] = $checkEmailExist->first_name;
        $this->data['last_name'] = $checkEmailExist->last_name;
        
        
        $setting_val = 30;
        $setting_value = Settings::where('alias_name','EMAIL_MOBILE_OTP_EXPIRE_TIME')->get();
      
        if(!$setting_value->isEmpty())
        {
            $setting_val = $setting_value[0]->setting_value;
        }
        
        $checkEmailExist->notify(new AdminForgotpassword($checkEmailExist));
        
        //Mail send
        
       /* $alias = "anjanayoga_forgot_password_verification_admin";
        $arrayreplace = array();
        $arrayreplace[] = "{user_name}";
        $arrayreplace[] = "{verification_code}";
        $arrayreplace[] = "{expire_min}";

        $arrayreplacedata = array();
        $arrayreplacedata[] = $checkEmailExist->first_name.' '.$checkEmailExist->last_name;
        $arrayreplacedata[] = $otp;
        $arrayreplacedata[] = $setting_val;

        $emailContent = Common::getEmailTemplate($alias, $arrayreplace, $arrayreplacedata);

        $this->data['content'] = $emailContent['content'];
        $this->data['subject'] = $emailContent['subject'];
        $this->data['email'] = $checkEmailExist->email;


        SendMailJob::dispatch($this->data);
        //End Mail send*/
                
        return redirect()->route('adminverifyotp')->with('success', 'Verification code sent successfully.');
    }
    
    public function adminVerifyOtp(Request $request) {
        $this->data['email'] = Session::get('requestEmail');
        return view('admincp.forgotpassword.adminVerifyOtp', $this->data);
    }

    public function verifyForgotOtp(Request $request) {
        
        $messsages = array(
            'otp_box1.required' => 'Please enter verification code',
            'otp_box2.required' => 'Please enter verification code',
            'otp_box3.required' => 'Please enter verification code',
            'otp_box4.required' => 'Please enter verification code',
        );
        $rules = array(
            'otp_box1' => 'required',
            'otp_box2' => 'required',
            'otp_box3' => 'required',
            'otp_box4' => 'required',
        );
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        $email = Session::get('requestEmail');
        if (empty(Session::get('adminRequestEmail'))) {
            return redirect()->back()->with('error', 'Please enter email address.');
        }
        $checkOtpExist = Admin::where('email',Session::get('adminRequestEmail'))->first();
        if (empty($checkOtpExist)) {
            return redirect()->back()->with('error', 'Verification code does not exist.');
        }

        if($request->otp_box1 && $request->otp_box2 && $request->otp_box3 && $request->otp_box4) {
            if(empty($request->otp_box1) && empty($request->otp_box2) && empty($request->otp_box3) && empty($request->otp_box4)) {
                return redirect()->back()->with('error', 'Please enter Verification code');
            }
        }
        $request_otp = $request->otp_box1.$request->otp_box2.$request->otp_box3.$request->otp_box4.$request->otp_box5.$request->otp_box6;
        if($checkOtpExist->msg_otp != $request_otp) {
            return redirect()->back()->with('error', 'Invalid Verification code');
        }        
        
        $current_date = date('Y-m-d H:i:s');
        if ($current_date >= $checkOtpExist->otp_expire_time) {
            return redirect()->back()->with('error',  'Verification code expired');
        }
        
        return redirect()->route('adminresetpassword')->with('success', 'Verification code verified successfully');
    }
    
    public function adminResetPassword() {
        return view('admincp.forgotpassword.adminResetPassword');
    }
    
    public function resetForgotPassword(Request $request) {
        if (empty(Session::get('adminRequestEmail'))) {
            return redirect()->back()->with('error', 'Please enter email address.');
        }
        $messsages = array(
            'n_password.required' => 'Please enter a new password',
            'n_password.min' => 'New password must contain atleast :min characters',
            'n_password.max' => 'New password must contain maximum :max characters',
            'con_password.required' => 'Please enter a confirm password',
            'con_password.min' => 'Confirm password must contain atleast :min characters',
            'con_password.max' => 'Confirm password must contain maximum :max characters',
            'con_password.different' => 'Confirm password must be different from current password',
            'con_password.same' => 'Confirm password does not match',
        );
        $rules = array(
            'n_password' => 'required|min:6|max:24',
            'con_password' => 'required|min:6|max:24|same:n_password|different:c_password'
        );
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            //echo '<pre>'; print_r($validator->messages()->getMessages()); echo '</pre>'; die;
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0]);
            }
        }
        $checkEmailExist = Admin::where('email',Session::get('adminRequestEmail'))->first();
        if (empty($checkEmailExist)) {
            return redirect()->back()->with('error', 'Please enter valid email');
        }
        $checkEmailExist->password = Hash::make($request->n_password);
        $checkEmailExist->msg_otp = Null;
        if ($checkEmailExist->save()) {
            return redirect()->route('admincp')->with('success', 'Your password has been reset successfully.');
        }
        return redirect()->back()->with('error', 'Something went wrong.please try again.');
    }        
    
    public function resendotp(Request $request) {
        $admin_email = Session::get('requestEmail');
        if ($admin_email === null) {
            $admin_email = Admin::find(Auth::guard('admin')->User()->id)->email;
        }
        $save_admin = Admin::where('email', $admin_email)->get()->first();

        if (!empty($save_admin)) {
            $otp = Common::generateOtp()['user_otp'];
            $otp_expire = Common::generateOtp()['expire_time'];
            
            $save_admin->msg_otp = $otp;
            $save_admin->otp_expire_time = $otp_expire;
            $save_admin->save();
            
            $setting_val = 30;
            $setting_value = Settings::where('alias_name','EMAIL_MOBILE_OTP_EXPIRE_TIME')->get();

            if(!$setting_value->isEmpty())
            {
                $setting_val = $setting_value[0]->setting_value;
            }
            
            $save_admin->notify(new AdminForgotpassword($save_admin));

            //Mail send
            
            /*$alias = "anjanayoga_forgot_password_verification_admin";
            $arrayreplace = array();
            $arrayreplace[] = "{user_name}";
            $arrayreplace[] = "{verification_code}";
            $arrayreplace[] = "{expire_min}";

            $arrayreplacedata = array();
            $arrayreplacedata[] = $save_admin->first_name.' '.$save_admin->last_name;
            $arrayreplacedata[] = $otp;
            $arrayreplacedata[] = $setting_val;

            $emailContent = Common::getEmailTemplate($alias, $arrayreplace, $arrayreplacedata);

            $this->data['content'] = $emailContent['content'];
            $this->data['subject'] = $emailContent['subject'];
            $this->data['email'] = $save_admin->email;


            SendMailJob::dispatch($this->data);*/
            
            //End Mail send
            
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['error' => 'Something went wrong.please try again.']);
        }
    }
}
