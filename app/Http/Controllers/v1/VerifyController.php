<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Common;
use App\Models\Settings;
use DB;
use App\Models\User;
use App\Models\UserAlumniInformations;
use App\Models\AlumniService;
use App\Models\AlumniSession;
use App\Models\UserColor;
use App\Models\Transaction;
use App\Models\UserDeviceToken;
use App\Models\UserProfile;
use App\Mail\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailJob;
use Auth;
use JWTAuth;
use Hash;
use App\Notifications\verifyUserMail;
use App\Notifications\WelcomeUserMail;

class VerifyController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*     * *****************   START : Rsend OTP    ******************* */
    public function resendOtp(Request $request) {

        $message = array(
            'source.required' => 'Please enter email or mobile number',
            'email.required' => 'Please enter email',
        );
        $rules = array(
            'source' => 'required|string|in:email,forgot_email,new_email',
            'email' => 'required',
        );

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }

        $maximum_attempt = Common::getMaxAttempt($alias = 'maximum_attempt');

        if ($request->source == 'email') {
            DB::beginTransaction();
            try {
                $save_detail = User::where('email', $request->email)->
                        orWhere('new_email', $request->email)->get()->first();
                if (empty($save_detail)) {
                    return response()->json(['message' => 'Email does not exist, Please check your email'], $this->failStatus);
                }

                $otp_email = Common::generateOtp();
                
                if($request->email == 'otony@mailinator.com'){
                    $email_otp = '1234';
                }else{
                    $email_otp = $otp_email['user_otp'];
                }
                
                $save_detail->email_otp = $email_otp;
                
                $save_detail->email_otp_expire = $otp_email['expire_time'];
                $save_detail->save();
                $this->data['email_otp_expire'] = $save_detail->email_otp_expire;

                //Mail send
                $check_email_on = Common::getSetting('EMAIL_ON_OFF');
                $email_on_off = 'off';
                if (!empty($check_email_on)) {
                    $email_on_off = $check_email_on;
                }

                $setting_val = 5;
                $setting_value = Settings::where('alias_name','EMAIL_MOBILE_OTP_EXPIRE_TIME')->get();

                if(!$setting_value->isEmpty())
                {
                    $setting_val = $setting_value[0]->setting_value;
                }

                $setting_email_val = 'support@banner.com';
                $setting_email_value = Settings::where('alias_name','CONTACT_US_EMAIL')->get();

                if(!$setting_email_value->isEmpty())
                {
                    $setting_email_val = $setting_email_value[0]->setting_value;
                }

                if($email_on_off == 'on'){
                    $save_detail->notify(new verifyUserMail($save_detail));
                }
                //End Mail send

                DB::commit();
                return response()->json(['message' => 'Verification code has been sent to registered email address', 'data' => $this->data], $this->successStatus);
            } catch (\Exception $e) {
                // \Log::error('Email send error');
                return response()->json(['message' => $e->getMessage()], $this->failStatus);
            }
        }  elseif ($request->source == 'forgot_email') {
            DB::beginTransaction();
            try {

                //remove user get
                $removed_user = User::where('email', $request->email)
                        ->withTrashed()
                        ->orderBy('id', 'desc')
                        ->first();
                if (!empty($removed_user)) {
                    if (!empty($removed_user->deleted_at)) {
                        return response()->json(['message' => 'Your account is removed. Please contact support for any queries'], $this->failStatus);
                    }
                }

                $save_detail = User::where('email', $request->email)->get()->first();
                if (empty($save_detail)) {
                    return response()->json(['message' => 'Email does not exist, Please check your email'], $this->failStatus);
                }
                
                if($save_detail->status == 'inactive'){
                
                    $contact_email = 'support@banner.com';
                    $contact_email_id = Common::getSetting('CONTACT_US_EMAIL');

                    if(!empty($contact_email_id)) {
                        $contact_email = $contact_email_id;
                    }
                    return response()->json(['message' => 'Your Fans Play Louder account has been deactivated. For more information, please contact us at '.$contact_email.'.'],$this->failStatus);
                }

                //Check forgot_attempt 
                $today = date("Y-m-d");
                $expire = $save_detail->forgot_attempt_date; //from database

                $today_time = strtotime($today);
                $expire_time = strtotime($expire);

                if ($expire_time == $today_time) {
                    if ($save_detail->forgot_attempt == $maximum_attempt) {
                        return response()->json(['message' => 'Your verification features suspended, Verification features not available till next day!'], $this->failStatus);
                    }

                    User::where('id', $save_detail->id)
                            ->update(array(
                                'forgot_attempt_date' => date("Y-m-d"),
                                'forgot_attempt' => $save_detail->forgot_attempt + 1
                    ));
                } else {
                    User::where('id', $save_detail->id)
                            ->update(array(
                                'forgot_attempt_date' => date("Y-m-d"),
                                'forgot_attempt' => 1
                    ));
                }
                //End check forgot_attempt
                

                $otp_email = Common::generateOtp();

                if($request->email == 'otony@mailinator.com'){
                    $email_otp = '1234';
                }else{
                    $email_otp = $otp_email['user_otp'];
                }
                
                $save_detail->forgot_otp_number = $email_otp;
                $save_detail->forgot_otp_expire = $otp_email['expire_time'];
                $save_detail->save();
                $this->data['email_otp_expire'] = $save_detail->forgot_otp_expire;

                //Mail send
                $check_email_on = Common::getSetting('EMAIL_ON_OFF');
                $email_on_off = 'off';
                if (!empty($check_email_on)) {
                    $email_on_off = $check_email_on;
                }

                $setting_val = 5;
                $setting_value = Settings::where('alias_name','EMAIL_MOBILE_OTP_EXPIRE_TIME')->get();

                if(!$setting_value->isEmpty())
                {
                    $setting_val = $setting_value[0]->setting_value;
                }

                $setting_email_val = 'support@banner.com';
                $setting_email_value = Settings::where('alias_name','CONTACT_US_EMAIL')->get();

                if(!$setting_email_value->isEmpty())
                {
                    $setting_email_val = $setting_email_value[0]->setting_value;
                }

                if($email_on_off == 'on'){
//                    $alias = "fpl_reset_your_password";
//                    $arrayreplace = array();
//                    $arrayreplace[] = "/{banner_img}/";
//                    $arrayreplace[] = "/{banner_icon_img}/";
//                    $arrayreplace[] = "/{user_name}/";
//                    $arrayreplace[] = "/{otp}/";
//                    $arrayreplace[] = "/{exp_minute}/";
//                    $arrayreplace[] = "/{contact_email}/";
//
//                    $arrayreplacedata = array();
//                    $arrayreplacedata[] = env('APP_URL') . '/public/images/email/email-header-bg.png';
//                    $arrayreplacedata[] = env('APP_URL') . '/public/images/email/forgot-password-icon.png';
//                    $arrayreplacedata[] = ucfirst($save_detail->user_name);
//                    $arrayreplacedata[] = $save_detail->forgot_otp_number;
//                    $arrayreplacedata[] = $setting_val;
//                    $arrayreplacedata[] = $setting_email_val;
//
//                    $emailContent = Common::getEmailTemplate($alias, $arrayreplace, $arrayreplacedata);
//
//                    $this->data['content'] = $emailContent['content'];
//                    $this->data['subject'] = $emailContent['subject'];
//                    $this->data['email'] = $save_detail->email;
//
//
//                    SendEmailJob::dispatch($this->data);
                }
                //End Mail send

                DB::commit();

                return response()->json(['message' => 'Verification code has been sent to registered email address', 'data' => $this->data], $this->successStatus);
            } catch (\Exception $e) {
                // \Log::error('Email send error');
                return response()->json(['message' => $e->getMessage()], $this->failStatus);
            }
        }  elseif ($request->source == 'new_email') {
            DB::beginTransaction();
            try {
                $save_detail = User::where('new_email', $request->email)->get()->first();
                if (empty($save_detail)) {
                    return response()->json(['message' => 'Email does not exist, Please check your email'], $this->failStatus);
                }

                $otp_email = Common::generateOtp();
                
                if($request->email == 'otony@mailinator.com'){
                    $email_otp = '1234';
                }else{
                    $email_otp = $otp_email['user_otp'];
                }

                $save_detail->email_otp = $email_otp;
                $save_detail->email_otp_expire = $otp_email['expire_time'];
                $save_detail->save();
                $this->data['email_otp_expire'] = $save_detail->email_otp_expire;
                
                //Mail send
                $check_email_on = Common::getSetting('EMAIL_ON_OFF');
                $email_on_off = 'off';
                if (!empty($check_email_on)) {
                    $email_on_off = $check_email_on;
                }

                $setting_val = 5;
                $setting_value = Settings::where('alias_name','EMAIL_MOBILE_OTP_EXPIRE_TIME')->get();

                if(!$setting_value->isEmpty())
                {
                    $setting_val = $setting_value[0]->setting_value;
                }

                $setting_email_val = 'support@banner.com';
                $setting_email_value = Settings::where('alias_name','CONTACT_US_EMAIL')->get();

                if(!$setting_email_value->isEmpty())
                {
                    $setting_email_val = $setting_email_value[0]->setting_value;
                }

                if($email_on_off == 'on'){
//                    $alias = "fpl_email_verification";
//                    $arrayreplace = array();
//                    $arrayreplace[] = "/{banner_img}/";
//                    $arrayreplace[] = "/{banner_icon_img}/";
//                    $arrayreplace[] = "/{user_name}/";
//                    $arrayreplace[] = "/{otp}/";
//                    $arrayreplace[] = "/{exp_minute}/";
//                    $arrayreplace[] = "/{contact_email}/";
//
//                    $arrayreplacedata = array();
//                    $arrayreplacedata[] = env('APP_URL') . '/public/images/email/email-header-bg.png';
//                    $arrayreplacedata[] = env('APP_URL') . '/public/images/email/email-icon.png';
//                    $arrayreplacedata[] = ucfirst($save_detail->user_name);
//                    $arrayreplacedata[] = $save_detail->email_otp;
//                    $arrayreplacedata[] = $setting_val;
//                    $arrayreplacedata[] = $setting_email_val;
//
//                    $emailContent = Common::getEmailTemplate($alias, $arrayreplace, $arrayreplacedata);
//
//                    $this->data['content'] = $emailContent['content'];
//                    $this->data['subject'] = $emailContent['subject'];
//                    $this->data['email'] = $save_detail->new_email;
//
//
//                    SendEmailJob::dispatch($this->data);
                }
                //End Mail send

                DB::commit();

                return response()->json(['message' => 'Verification code has been sent to Email Address', 'data' => $this->data], $this->successStatus);
            } catch (\Exception $e) {
                // \Log::error('Email send error');
                return response()->json(['message' => $e->getMessage()], $this->failStatus);
            }
        }
    }
    /*     * *****************   END : Rsend OTP    ******************* */


    /*     * *****************   START : Verify OTP for email or mobile    ******************* */
    public function verifyOtp(Request $request) {
        $message = array(
            'otp_number.required' => 'Please enter verification code',
        );
        $rules = array(
            'otp_number' => 'required|min:4|max:4',
        );

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }

        $uDetail = User::where('new_email', $request->email)
                ->orWhere('email', $request->email)
                ->get();
        
        if ($uDetail->isEmpty()) {
            return response()->json(['message' => 'Email does not exists.'], $this->failStatus);
        }

        if (!empty($uDetail[0]->new_email)) {
            $email_mobile_verify = $uDetail[0]->new_email_verify;
        } else {
            $email_mobile_verify = $uDetail[0]->email_verify;
        }
        $userDetail = User::where('email', $request->email)
            ->where('email_otp', $request->otp_number)
            ->orWhere('new_email', $request->email)->get();
        if ($userDetail->isEmpty()) {
            return response()->json(['message' => 'Please enter valid verification code for email'], $this->failStatus);
        }

        $current_date = date('Y-m-d H:i:s');

        $otp_expire = $uDetail[0]->email_otp_expire;

        if ($current_date >= $otp_expire) {
            return response()->json(['message' => 'Verification code expired'], $this->failStatus);
        }

        $stripe_form_filled = 0;

        DB::beginTransaction();
        try {
            $userDetail = User::find($userDetail[0]->id);

            if (!empty($userDetail->new_email)) {
                $userDetail->email = $request->email;
                $userDetail->new_email = Null;
            }
            $userDetail->email_verify = 'Yes';
            $userDetail->email_verified_at = date('Y-m-d H:i:s');
            $userDetail->email_otp = Null;

            if ($request->device_token) {
                $userDetail->device_token = $request->device_token;
            }

            if ($request->device_type) {
                $userDetail->device_type = $request->device_type;
            }

            if ($request->device_model) {
                $userDetail->device_model = $request->device_model;
            }

            if ($request->uu_id) {
                $userDetail->uu_id = $request->uu_id;
            }

            if ($request->device_os) {
                $userDetail->device_os = $request->device_os;
            }

            if ($request->app_version) {
                $userDetail->app_version = $request->app_version;
            }

            if ($request->api_version) {
                $userDetail->api_version = $request->api_version;
            }

            if ($userDetail->save()) {
            
                $device_token = UserDeviceToken::where('uu_id', $request->uu_id)->first();            
                if(empty($device_token)) {
                    $device_token = new UserDeviceToken();                
                }
                $device_token->user_id = $userDetail->id;
                $device_token->device_type = $request->device_type;
                $device_token->device_token = $request->device_token;
                $device_token->device_model = $request->device_model;
                $device_token->device_os = $request->device_os;
                $device_token->app_version = $request->app_version;
                $device_token->api_version = $request->api_version;
                $device_token->uu_id = $request->uu_id;
                $device_token->save();
                
                $this->data['id'] = $userDetail->id;

                $this->data['user_name'] = $userDetail->user_name;
                $this->data['email'] = $userDetail->email;
                $this->data['email_verify'] = $userDetail->email_verify == 'Yes' ? true : false;
                $this->data['push_notify'] = $userDetail->push_notify == 'Yes' ? true : false;
//                $this->data['device_token'] = $userDetail->device_token;
//                $this->data['device_type'] = $userDetail->device_type;
                $this->data['uu_id'] = $userDetail->uu_id;
                $this->data['google_id'] = $userDetail->google_id;
                $this->data['apple_id'] = $userDetail->apple_id;
                //Social user check
                $this->data['is_social_user'] = false;
                if(!empty($userDetail->fb_id) || !empty($userDetail->google_id) || !empty($userDetail->apple_id)) {
                    $this->data['is_social_user'] = true;                
                }                
                $this->data['token'] = JWTAuth::fromUser($userDetail);
                
                DB::commit();
                return response()->json(['message' => 'Verify Successfully', 'data' => $this->data], $this->successStatus);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*     * *****************   END : Verify OTP for email or mobile    ******************* */

    /*     * *****************   START : Verify OTP new email or mobile   ******************* */
    public function verifyNewOtpEmailMobile(Request $request) {

        $message = array(
            'otp_number.required' => 'Please enter verification code',
        );
        $rules = array(
            'otp_number' => 'required|min:4|max:4',
        );

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }

        $maximum_attempt = Common::getMaxAttempt($alias = 'maximum_attempt');

        $uDetail = User::where('new_email', $request->sourceid)
                ->get();

        if ($uDetail->isEmpty()) {
            return response()->json(['message' => 'Email does not exists.'], $this->successStatus);
        }

        if ($request->source == 'email') {
            $email_mobile_verify = $uDetail[0]->new_email_verify;
            $expire = $uDetail[0]->verify_email_attempt_date;
            $attempt = $uDetail[0]->verify_email_attempt;

            $userDetail = User::where([
                        'new_email' => $request->sourceid,
                        'email_otp' => $request->otp_number,
                    ])->get();
        }


        if ($userDetail->isEmpty()) {

            if ($email_mobile_verify == "Yes") {
                //Check verify login attempt 
                $today = date("Y-m-d");
                $expire = $uDetail[0]->login_attempt_date; //from database

                $today_time = strtotime($today);
                $expire_time = strtotime($expire);

                if ($expire_time == $today_time) {
                    if ($uDetail[0]->login_attempt == $maximum_attempt) {
                        return response()->json(['message' => 'Your login features suspended,Login features not available till next day!'], $this->failStatus);
                    }

                    User::where('id', $uDetail[0]->id)
                            ->update(array(
                                'login_attempt_date' => date("Y-m-d"),
                                'login_attempt' => $uDetail[0]->login_attempt + 1
                    ));
                } else {
                    User::where('id', $uDetail[0]->id)
                            ->update(array(
                                'login_attempt_date' => date("Y-m-d"),
                                'login_attempt' => 1
                    ));
                }
            } else {
                $today = date("Y-m-d");

                $today_time = strtotime($today);
                $expire_time = strtotime($expire);

                if ($expire_time == $today_time) {
                    if ($attempt == $maximum_attempt) {
                        return response()->json(['message' => 'Your verification features suspended, Verification features not available till next day!'], $this->failStatus);
                    }

                    if ($request->source == 'email') {
                        User::where('id', $uDetail[0]->id)
                                ->update(array(
                                    'verify_email_attempt_date' => date("Y-m-d"),
                                    'verify_email_attempt' => $attempt + 1
                        ));
                    }
                } else {
                    if ($request->source == 'email') {
                        User::where('id', $uDetail[0]->id)
                                ->update(array(
                                    'verify_email_attempt_date' => date("Y-m-d"),
                                    'verify_email_attempt' => 1
                        ));
                    }
                }
            }

            if ($request->source == 'email') {
                return response()->json(['message' => 'Please enter valid verification code for email'], $this->failStatus);
            } else {
                return response()->json(['message' => 'The verification code you entered is invalid. Please try again.'], $this->failStatus);                
            }
        } else {
            $today = date("Y-m-d");

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

            if ($expire_time == $today_time) {
                if ($uDetail[0]->verify_email_attempt == $maximum_attempt) {
                    return response()->json(['message' => 'Your verification features suspended, Verification features not available till next day!'], $this->failStatus);
                }

                if ($request->source == 'email') {
                    User::where('id', $uDetail[0]->id)
                            ->update(array(
                                'verify_email_attempt_date' => date("Y-m-d"),
                                'verify_email_attempt' => $attempt + 1
                    ));
                }
            } else {
                if ($request->source == 'email') {
                    User::where('id', $uDetail[0]->id)
                            ->update(array(
                                'verify_email_attempt_date' => date("Y-m-d"),
                                'verify_email_attempt' => 1
                    ));
                }
            }
        }

        $current_date = date('Y-m-d H:i:s');
        
        if ($request->source == 'email') {
            $otp_expire = $uDetail[0]->email_otp_expire;
        }

        if ($current_date >= $otp_expire) {
            return response()->json(['message' => 'Verification code expired'], $this->failStatus);
        }        
        $stripe_form_filled = 0;

        DB::beginTransaction();
        try {
            $userDetail = User::find($userDetail[0]->id);
            
            
            if ($request->source == 'email') {
                $userDetail->email = $request->sourceid;
                $userDetail->new_email = Null;
                $userDetail->email_verify = 'Yes';
                $userDetail->new_email_verify = 'Yes';
                $userDetail->email_verified_at = date('Y-m-d H:i:s');
                $userDetail->email_otp = Null;
                $userDetail->verify_email_attempt_date = Null;
                $userDetail->verify_email_attempt = Null;
            }
            $userDetail->status = '1';            

            if ($request->device_token) {
                $userDetail->device_token = $request->device_token;
            }

            if ($request->device_type) {
                $userDetail->device_type = $request->device_type;
            }

            if ($request->device_model) {
                $userDetail->device_model = $request->device_model;
            }

            if ($request->device_os) {
                $userDetail->device_os = $request->device_os;
            }

            if ($request->app_version) {
                $userDetail->app_version = $request->app_version;
            }

            if ($request->api_version) {
                $userDetail->api_version = $request->api_version;
            }

            if ($request->uu_id) {
                $userDetail->uu_id = $request->uu_id;
            }

            if ($userDetail->save()) {
                
                $this->data['id'] = $userDetail->id;
                $this->data['user_name'] = $userDetail->user_name;

                $this->data['email'] = $userDetail->email;
                $this->data['image'] = !empty($userDetail->image) ? asset('public/uploads/user_profile/' . $userDetail->image) : "";

                $this->data['device_token'] = $userDetail->device_token;
                $this->data['device_type'] = $userDetail->device_type;
                $this->data['uu_id'] = $userDetail->uu_id;
                $this->data['token'] = JWTAuth::fromUser($userDetail);
                $this->data['email_verify'] = $userDetail->email_verify == 'Yes' ? true : false;
                $this->data['push_notify'] = $userDetail->push_notify == 'Yes' ? true : false;

                $is_profile = 0;
                if (!empty($userDetail->first_name)) {
                    $is_profile = 1;
                }
                $this->data['is_profile'] = $is_profile;

                if ($request->is_social == 1) {
                    $user = User::find($userDetail->id);
                    $user->fb_id = Null;
                    $user->google_id = Null;
                    $user->apple_id = Null;
                    $user->save();
                    
                    $check_email_on = Common::getSetting('EMAIL_ON_OFF');
                    $email_on_off = 'off';
                    if (!empty($check_email_on)) {
                        $email_on_off = $check_email_on;
                    }
                    $setting_email_val = 'support@banner.com';
                    $setting_email_value = Settings::where('alias_name','CONTACT_US_EMAIL')->get();

                    if(!$setting_email_value->isEmpty())
                    {
                        $setting_email_val = $setting_email_value[0]->setting_value;
                    }
                    
                    if($email_on_off == 'on'){
                        
//                        $alias = "fans_play_louder_-_generated_password";
//                        $arrayreplace = array();
//                        $arrayreplace[] = "/{user_name}/";
//                        $arrayreplace[] = "/{password}/";
//                        $arrayreplace[] = "/{banner_img}/";
//                        $arrayreplace[] = "/{banner_icon_img}/";
//                        $arrayreplace[] = "/{contact_email}/";
//
//                        $st = (string) $generated_password;
//                        $st2 = strval($st);
//
//                        $arrayreplacedata = array();
//                        $arrayreplacedata[] = ucfirst($user->user_name);
//                        $arrayreplacedata[] = $st2;
//                        $arrayreplacedata[] = env('APP_URL') . '/public/images/email/rounded-bg.png';
//                        $arrayreplacedata[] = env('APP_URL') . '/public/images/email/banner-02-01.png';
//                        $arrayreplacedata[] = $setting_email_val;
//
//                        $emailContent = Common::getEmailTemplate($alias, $arrayreplace, $arrayreplacedata);
//
//                        $this->data['content'] = $emailContent['content'];
//                        $this->data['subject'] = $emailContent['subject'];
//                        $this->data['email'] = $user->email;
//
//                        SendEmailJob::dispatch($this->data);
                    }
                    unset($this->data['content']);
                    unset($this->data['subject']);

                    /* End Start Mail code for email */
                }

                DB::commit();
                return response()->json(['message' => 'Verify Succefully', 'data' => $this->data], $this->successStatus);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }

    /*     * *****************   END : Verify OTP new email    ******************* */

}
