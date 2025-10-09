<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modal\Common;
use App\Models\User;
use App\Models\UserDeviceToken;
use Auth;
use Hash;
use JWTAuth;

class LogoutController extends Controller
{
    public $data = [];
    public $successStatus = 200;
    public $internalServer = 500;
    public $failStatus = 400;

    /********************   START : logout   *********************/     
    public function logout(Request $request, $uu_id) {
        if (JWTAuth::getToken() ) {
//            $user_token_delete = UserDeviceToken::where('user_id', Auth::User()->id)->where('uu_id', $uu_id)->delete();
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message'=>'Logout successfully.'], $this->successStatus);
        }else{
            return response()->json(['message'=>'Something went wrong. please try again.'], $this->internalServer);
        }
    }
    /********************   END : logout   *********************/     
}
