<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\UserProfile;
use App\Models\UserProfileAccess;
use App\Models\UserDeviceToken;
use App\Models\Country;
use Auth;
use DB;
use Hash;
use JWTAuth;
use Session;
use Image;
use App\Notifications\WelcomeUserMail;

class LoginController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';
    
    /********************   START : login     *********************/  
    public function login(Request $request) {

        $messsages = array(
            'login_with.required' => 'please enter login type',
            'email.required' => 'please enter email',
            'social_id.required' => 'please enter social id',
            'device_token.required' => 'please enter device token',
            'device_type.required' => 'please enter device type',
            'uu_id' => 'Please enter uuid'
        );
        $rules = array(
            'login_with' => 'required',
//            'email' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
            'uu_id' => 'required'
        );

        if ($request->login_with == 'Email') {
            $rules['email'] = 'required';
        }

        if (!empty($request->login_with)) {
            if ($request->login_with == 'Google' || $request->login_with == 'Apple') {
                $rules['social_id'] = 'required';
            }
        }

        if ($request->uu_id == "") {
            return response()->json(['message' => 'uuid is required'], $this->failStatus);
        }
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }

        if ($request->login_with == 'Google') {

            if (isset($request->email) && !empty($request->email)) {
                $check_login_detail = User::Where('email', '=', strtolower($request->email))->get();
            } else {
                $check_login_detail = User::Where('google_id', '=', $request->social_id)->get();
            }
        } else if ($request->login_with == 'Apple') {
            $check_login_detail = User::Where('apple_id', '=', $request->social_id)->get();
        } else if ($request->login_with == 'Email') {
            $check_login_detail = User::Where('email', '=', strtolower($request->email))->get();
        }

        $is_new_user = false;
        if (!$check_login_detail->isEmpty()) {
            $save_user_detail = User::find($check_login_detail->first()->id);

            if (empty($save_user_detail)) {
                return response()->json(['message' => 'User not found'], $this->failStatus);
            }
        } else {

            $save_user_detail = new User();

            if ($request->login_with == 'Google') {
                $save_user_detail->google_id = $request->social_id;
            } else if ($request->login_with == 'Apple') {
                $save_user_detail->apple_id = $request->social_id;
            }

            if (isset($request->email) && !empty($request->email)) {
                $save_user_detail->email = strtolower($request->email);
            }
            $save_user_detail->user_name = $request->user_name;

            if ($request->login_with != 'Email') {
                $save_user_detail->email_verify = "Yes";
            } else {
                $save_user_detail->email_verify = "No";
            }
        }

        $save_user_detail->device_type = $request->device_type;
        $save_user_detail->device_token = $request->device_token;
        $save_user_detail->device_model = $request->device_model;
        $save_user_detail->device_os = $request->device_os;
        $save_user_detail->app_version = $request->app_version;
        $save_user_detail->api_version = $request->api_version;
        $save_user_detail->uu_id = $request->uu_id;

        if ($request->login_with == 'Apple') {
            $check_login_detail = User::Where('apple_id', '=', $request->social_id)->get();

            $apple_auth_code = $request->apple_auth_code;

            if (!empty($apple_auth_code)) {
                // $redirect_uri = env('APP_URL') . '/callback/apple';
                $client_id = env('CLIENT_ID');
                $client_secret = env('CLIENT_SECRET');

                $res = $this->http('https://appleid.apple.com/auth/token', [
                    'grant_type' => 'authorization_code',
                    'code' => $apple_auth_code,
                    // 'redirect_uri' => $redirect_uri,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                ]);

                $save_user_detail->revoke_access_token = $res->access_token;
            }
        }

        if ($save_user_detail->save()) {

            $device_token = UserDeviceToken::where('uu_id', $request->uu_id)->first();
            if (empty($device_token)) {
                $device_token = new UserDeviceToken();
            }
            $device_token->user_id = $save_user_detail->id;
            $device_token->device_type = $request->device_type;
            $device_token->device_token = $request->device_token;
            $device_token->device_model = $request->device_model;
            $device_token->device_os = $request->device_os;
            $device_token->app_version = $request->app_version;
            $device_token->api_version = $request->api_version;
            $device_token->uu_id = $request->uu_id;
            $device_token->save();

            //create token
            if ($save_user_detail->status == 'inactive') {
                return response()->json(['message' => 'Your account has been deactivated'], $this->failStatus);
            }

            $token = JWTAuth::fromUser($save_user_detail);
            $date = strtotime(date('Y-m-d H:i:s'));

            User::where('id', '!=', $save_user_detail->id)
                    ->where('device_token', '=', $save_user_detail->device_token)
                    ->update(array(
                        'device_token' => null
            ));
            $this->data['id'] = $save_user_detail->id;
            $this->data['user_name'] = $save_user_detail->user_name;

            $this->data['image'] = !empty($save_user_detail->image) ? asset('public/uploads/user_profile/' . $save_user_detail->image) : "";
            $this->data['email'] = $save_user_detail->email;

            $this->data['token'] = $token;

            //Social user check
            $this->data['is_social_user'] = false;
            if (!empty($save_user_detail->google_id) || !empty($save_user_detail->apple_id)) {
                $this->data['is_social_user'] = true;
            }

            return response()->json(['message' => 'Login successfully', 'data' => $this->data], $this->successStatus);
        } else {
            return response()->json(['message' => 'Something went wrong.please try again'], $this->internalServer);
        }
    }

    /********************   END : login    *********************/
    
     public function http($url, $params=false) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($params)
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'User-Agent: curl', # Apple requires a user agent header at the token endpoint
        ]);
        $response = curl_exec($ch);
        return json_decode($response);
    }


    public function httprevoke($url, $params=false) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($params)
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'content-type: application/x-www-form-urlencoded',
          'Accept: application/json',
          'User-Agent: curl', # Apple requires a user agent header at the token endpoint
        ]);
        $response = curl_exec($ch);
        return json_decode($response);
    }
    
    /********************   START : Update Profile    *********************/
    public function updateProfile(Request $request) {
        
        $messages = array(
            'image.required' => 'Please select image.',
        );

        $rules = array(
            'image' => 'required',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        
        $user_id = Auth::User()->id;
        
        $save_user_profile = User::find($user_id);
        if ($request->hasFile('image')) {
            $result = Common::uploadSingleImage($request->image, 'user_profile');

            if ($result['status'] == 0) {
                return response()->json(['message' => 'Result not found'], $this->failStatus);
            } else {
                $save_user_profile->image = $result['data'];
            }
        }
        $save_user_profile->save();
        
        DB::beginTransaction();
        try {
            return response()->json(['message' => 'Profile updated successfully!','data' => $this->data], $this->successStatus);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
        return response()->json(['message' => 'Something went wrong. please try again'], $this->internalServer);
    }
    /********************   END : Update Profile    *********************/
    
    /********************   START : Add device token    *********************/
    public function addDeviceToken(Request $request) {
       
        if ($request->user_id != "") {
            $userId = $request->user_id;

            $user_detail = User::find($userId);
            if (!empty($user_detail)) {
                $user_detail->uu_id = $request->uu_id;
                $user_detail->device_type = $request->device_type;
                $user_detail->device_token = $request->device_token;
                $user_detail->device_model = $request->device_model;
                $user_detail->device_os = $request->device_os;
                $user_detail->app_version = $request->app_version;
                $user_detail->api_version = $request->api_version;
                $user_detail->save();
            }
        }
            
        $device_token = UserDeviceToken::where('uu_id', $request->uu_id)->first();            
        if(empty($device_token)) {
            $device_token = new UserDeviceToken();                
        }
        //$device_token->user_id = $user_detail->id;
        $device_token->uu_id = $request->uu_id;
        $device_token->device_type = $request->device_type;
        $device_token->device_token = $request->device_token;
        $device_token->device_model = $request->device_model;
        $device_token->device_os = $request->device_os;
        $device_token->app_version = $request->app_version;
        $device_token->api_version = $request->api_version;
        $device_token->uu_id = $request->uu_id;
        $device_token->save();
        
        return response()->json(['message' => 'Token saved successfully'],$this->successStatus);       
    }
    /********************   END : Add device token    *********************/
    
    public function sendPushNotification(Request $request){
        
        $messages = array(
            'device_token.required' => 'Please pass the devise tokene.',
            'device_type.required' => 'Please pass the devise type.',
        );

        $rules = array(
            'device_token' => 'required',
            'device_type' => 'required',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        
        $notificationContent = [];
        $notificationContent['message'] = "Test Notification: This is a sample push message.";
        $notificationContent['redirection_id'] = Null;
        $notification_token = array($request->device_token);
        $sendNotification = Common::sendPushNotification($notification_token, $notificationContent, $request->device_type);
        
        return response()->json(['message' => 'Notification send successfully'],$this->successStatus);   
    }
}
