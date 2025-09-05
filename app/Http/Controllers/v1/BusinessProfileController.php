<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\UserDeviceToken;
use App\Models\BusinessProfile;
use Auth;
use DB;
use Hash;
use JWTAuth;
use Session;

class BusinessProfileController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';
    
    /********************   START : Add/Update Business Profile    *********************/
    public function addUpdateBusinessProfile(Request $request) {
        
        $messages = array(
            'type.required' => 'Please select type',
            'type.in' => 'Please select any option from type',
            'business_name.required' => 'Please enter your profile name.',
            'business_name.min' => 'Profile name should be minimum :min characters.',
            'business_name.max' => 'Profile name should be maximum :max characters.',
            'email.email' => 'Please enter valid email address.',
            'email.unique' => 'Email already exists.',
            'user_name.required' => 'Please enter your user name.',
            'user_name.min' => 'User name should be minimum :min characters.',
            'user_name.max' => 'User name should be maximum :max characters.',
            'mobile.numeric' => 'Please enter a valid phone number.',
            'mobile.digits' => 'Please enter a 10 -digit phone number ',
            'mobile.unique' => 'Phone is already exists.',
        );

        $rules = array(
            'type' => 'required|in:business,personal',
            'user_name' => 'required|min:2|max:32',
        );
        
        if(isset($request->business_profile_id) && !empty($request->business_profile_id)) {
            $rules['email'] = 'string|email|max:250|unique:business_details,email,' . $request->business_profile_id . ',id,deleted_at,NULL';
            $rules['mobile'] = 'numeric|digits_between:10,14|unique:business_details,mobile,' . $request->business_profile_id . ',id,deleted_at,NULL';
        } else {
            $rules['email'] = 'string|email|max:255|unique:business_details,email,NULL,NULL,deleted_at,NULL';
            $rules['mobile'] = 'numeric|digits_between:10,14|unique:business_details,mobile,NULL,NULL,deleted_at,NULL';
        }
        
        if($request->type == 'business') {
            $rules['business_name'] = 'required|min:2|max:32';
        }
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        
        $user_id = Auth::User()->id;
                
        if(isset($request->business_profile_id) && !empty($request->business_profile_id)) {
            $save_business_profile = BusinessProfile::find($request->business_profile_id);
            if(empty($save_business_profile)) {
                return response()->json(['message' => 'Please pass valid user profile id'], $this->failStatus);
            }
        }else{
            $save_business_profile = new BusinessProfile();
        }
        $save_business_profile->user_id = $user_id;
        $save_business_profile->type = $request->type;
        $save_business_profile->user_name = $request->user_name;
        $save_business_profile->business_name = $request->business_name;
        $save_business_profile->email = strtolower($request->email);
        $save_business_profile->mobile = $request->mobile;
        
        if ($request->hasFile('image')) {
            $result = Common::uploadSingleImage($request->image, 'user_profile');

            if ($result['status'] == 0) {
                return response()->json(['message' => 'Result not found'], $this->failStatus);
            } else {
                $save_business_profile->image = $result['data'];
            }
        }
        $save_business_profile->save();        
               
        DB::beginTransaction();
        try {        
            if(isset($request->business_profile_id) && !empty($request->business_profile_id)) {
                return response()->json(['message' => 'Business profile updated successfully!'], $this->successStatus);
            } else {
                return response()->json(['message' => 'Business profile created successfully!'], $this->successStatus);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
        return response()->json(['message' => 'Something went wrong. please try again'], $this->internalServer);
    }
    /********************   END : Add/Update Business Profile    *********************/
            
    /*******************   START : Business list    ********************/
    public function getBusinessList(Request $request) {
        try {
            $userId = Auth::User()->id;

            $business_detail = BusinessProfile::where('user_id', $userId);
            
            $total_profile = $business_detail->count();
            if (isset($request->offset) && isset($request->limit)) {
                $business_detail = $business_detail->skip($request->offset)->take($request->limit)->get();
            } else {
                $business_detail = $business_detail->get();
            }

            if(!$business_detail->isEmpty()) {
                foreach($business_detail as $key => $val) {
                    $val['image'] = !empty($val->image) ? asset('public/uploads/user_profile/' . $val->image) : "";                    
                }
            }

            return response()->json(['message' => 'Business detail', 'total_profile' => $total_profile, 'data' => $business_detail], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : Business list    ********************/
            
    /*******************   START : Business details    ********************/
    public function getBusinessDetail($business_profile_id) {
        try {
            $userId = Auth::User()->id;

            $business_detail = BusinessProfile::where('user_id', $userId)->where('id', $business_profile_id)->first();

            if(!empty($business_detail)) {
                $business_detail['image'] = !empty($business_detail->image) ? asset('public/uploads/user_profile/' . $business_detail->image) : "";                
            }

            return response()->json(['message' => 'Business detail', 'data' => $business_detail], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : Business details    ********************/
    
    /********************   START : Delete Business Profile     *********************/
    public function deleteBusinessDetail($business_profile_id) {
        try {

            $id = Auth::User()->id;

            $businessProfile = BusinessProfile::where('user_id', $id)->where('id', $business_profile_id)->first();

            if (empty($businessProfile)) {
                return response()->json(['message' => $this->noDataMessage], $this->failStatus);
            }

            $businessProfile->delete();

            return response()->json(['message' => 'Business Profile successfully deleted'], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Delete Business Profile     *********************/
        
}
