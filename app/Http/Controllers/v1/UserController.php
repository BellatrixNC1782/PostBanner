<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\UserDeviceToken;
use Auth;
use DB;
use Hash;
use JWTAuth;
use Session;

class UserController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';
            
    /*******************   START : User details    ********************/
    public function userDetails() {
        try {
            $userId = Auth::User()->id;

            $save_user_detail = User::find($userId);

            $this->data['id'] = $save_user_detail->id;
            $this->data['user_name'] = $save_user_detail->user_name;

            $this->data['image'] = !empty($save_user_detail->image) ? asset('public/uploads/user_profile/' . $save_user_detail->image) : "";
            $this->data['email'] = $save_user_detail->email;

            //Social user check
            $this->data['is_social_user'] = false;
            if (!empty($save_user_detail->google_id) || !empty($save_user_detail->apple_id)) {
                $this->data['is_social_user'] = true;
            }

            return response()->json(['message' => 'User detail', 'data' => $this->data], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : User details    ********************/
    
    /********************   START : Delete user     *********************/
    public function deleteUser() {
        try {

            $id = Auth::User()->id;

            $user = User::where('id', $id)->first();

            if (empty($user)) {
                return response()->json(['message' => $this->noDataMessage], $this->failStatus);
            }

            if (Auth::user()->id != $id) {
                return response()->json(['message' => "Something went wrong. please try again"], $this->failStatus);
            }


            $revoke_access_token = $user->revoke_access_token;
            $apple_id = $user->apple_id;

            $client_id = env('CLIENT_ID');
            $client_secret = env('CLIENT_SECRET');

            if (!empty($revoke_access_token) && !empty($apple_id)) {
                $this->httprevoke('https://appleid.apple.com/auth/revoke', [
                    'token' => $revoke_access_token, // response of token
                    'token_type_hint' => 'access_token',
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                ]);
            }

            $user->delete();

            UserDeviceToken::where('user_id', $id)->delete();

            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Your Account successfully deleted'], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Delete user     *********************/

    /********************   START : http     *********************/  
    public function http($url, $params = false) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($params)
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'User-Agent: curl', # Apple requires a user agent header at the token endpoint
        ]);
        $response = curl_exec($ch);
        return json_decode($response);
    }
    /********************   END : http    *********************/
    
    /********************   START : http revoke     *********************/  
    public function httprevoke($url, $params = false) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($params)
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'content-type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'User-Agent: curl', # Apple requires a user agent header at the token endpoint
        ]);
        $response = curl_exec($ch);
        return json_decode($response);
    }
    /********************   END : http revoke    *********************/
        
}
