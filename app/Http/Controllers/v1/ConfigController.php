<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Common;
use App\Models\Country;
use App\Models\Categories;
use App\Models\AppVersion;
use Auth;
use Hash;
use JWTAuth,Validator;
use DB;

class ConfigController extends Controller
{
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
    
    /********************   START : Get config values    *********************/
    public function getconfig(Request $request, $configKey, $device_type) {
        
        try {

            if(empty($configKey)) {
                return response()->json(['message' => 'Please enter config key'], $this->failStatus);            
            }
            if ($configKey != '9g[$ax6JSyc-RTPdFf|[FPP3WnTBr9K+-pbB]zH#') {
                return response()->json(['message' => 'permission denied.'], $this->failStatus);
            }
            $setting_data = array();
            $setting = Settings::whereIn('type', ['general', $device_type])->get(['setting_title', 'setting_key', 'setting_value', 'alias_name','type']);
            if(!$setting->isEmpty()) {
                foreach ($setting as $key => $value) {
                    $setting_data[$key]['setting_title'] = $value->setting_title;
                    $setting_data[$key]['setting_key'] = $value->setting_key;
                    $setting_data[$key]['setting_value'] = base64_encode($value->setting_value);
                    $setting_data[$key]['alias_name'] = $value->alias_name;
                    $setting_data[$key]['type'] = $value->type;
                }            
            }

            $tearm_and_condition_url = array(
                'setting_title' => 'Terms and condition url',
                'setting_key' => 'TERMS_AND_CONDITION_URL',
                'setting_value' => base64_encode(route('termsofusemobile')),
                'alias_name' => 'TERMS_AND_CONDITION_URL',
            );
            
            if(!empty($tearm_and_condition_url)) {
                array_push($setting_data, $tearm_and_condition_url);
            }
            
            $privacy_policy_url = array(
                'setting_title' => 'Privacy policy url',
                'setting_key' => 'PRIVACY_POLICY_URL',
                'setting_value' => base64_encode(route('privacypolicymobile')),
                'alias_name' => 'PRIVACY_POLICY_URL',
            );
            
            if(!empty($privacy_policy_url)) {
                array_push($setting_data, $privacy_policy_url);
            }
            
            $app_store_link = array(
                'setting_title' => 'App store url',
                'setting_key' => 'APP_STORE_URL',
                'setting_value' => base64_encode(env('APP_URL')),
                'alias_name' => 'APP_STORE_URL',
            );
            
            if(!empty($app_store_link)) {
                array_push($setting_data, $app_store_link);
            }
            
            $play_store_link = array(
                'setting_title' => 'Play store url',
                'setting_key' => 'PLAY_STORE_URL',
                'setting_value' => '',
                'alias_name' => 'PLAY_STORE_URL',
            );
            
            if(!empty($play_store_link)) {
                array_push($setting_data, $play_store_link);
            }
            
            $settings_response = [];
            if (!empty($setting_data)) {
                foreach ($setting_data as $item) {
                    $settings_response[$item['setting_key']] = $item['setting_value'];
                }
            }

            $data = AppVersion::first();

//            if(!empty($data))
//            {
//                if($device_type == "android")
//                {
//                    $settings_response['android_min_version'] = base64_encode($data->android_min_version);
//                    $settings_response['android_max_version'] = base64_encode($data->android_max_version);
//                    $settings_response['android_force_update'] = (!empty($data->android_force_update)) ? base64_encode($data->android_force_update) : base64_encode(0);
//                }elseif ($device_type == "ios") {
//                    $settings_response['ios_min_version'] = base64_encode($data->ios_min_version);
//                    $settings_response['ios_max_version'] = base64_encode($data->ios_max_version);
//                    $settings_response['ios_force_update'] = base64_encode($data->ios_force_update);
//                }
//            }

            return response()->json(['data' => $settings_response], $this->successStatus);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Get config values    *********************/
    
    /********************   START : Get country list    *********************/
    public function getCountryList(){
        try {
            
            $data['country_list'] = Country::select('id','country','country_code','country_sign','currency_name','date_format')->where('status','active')->get();
            
            return response()->json(['data' => $data], $this->successStatus);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Get country list    *********************/
    
    /********************   START : Get category list    *********************/
    public function getCategoryList(){
        try {
            
            $data['category_list'] = Categories::select('id','name')->where('status','active')->get();
            
            return response()->json(['data' => $data], $this->successStatus);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Get category list    *********************/

}
