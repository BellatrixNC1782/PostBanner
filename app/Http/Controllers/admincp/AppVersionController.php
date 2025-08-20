<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AppVersion;
use Redirect;
use App\Models\User;
use App\Models\Common;
use DB;

class AppVersionController extends Controller
{        
    public function appVersion(){
        $this->data['version'] = AppVersion::orderBy('id','desc')->first();
        return view('admincp.appversion.appversion', $this->data);
    }
    
    public function appVersionUpdate(Request $request){
        $rules = array(
            'ios_min_version' => 'required',
            'ios_max_version' => 'required',
            'ios_force_update' => 'required',
            'android_min_version' => 'required',
            'android_max_version' => 'required',
            'android_force_update' => 'required',
        );
        $messages = array(
            'ios_min_version.required' => 'Please enter ios min version',
            'ios_max_version.required' => 'Please enter ios max version',
            'ios_force_update.required' => 'IOS force update is required',
            'android_min_version.required' => 'Please enter android min version',
            'android_max_version.required' => 'Please enter android max version',
            'android_force_update.required' => 'Android force update is required',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $version = AppVersion::orderBy('id','desc')->first();
        if(empty($version)) {
            $save_version = new AppVersion();            
        } else {
            $save_version = AppVersion::orderBy('id','desc')->first();            
        }
        $save_version->ios_min_version = $request->ios_min_version;
        $save_version->ios_max_version = $request->ios_max_version;
        $save_version->ios_force_update = $request->ios_force_update;
        $save_version->android_min_version = $request->android_min_version;
        $save_version->android_max_version = $request->android_max_version;
        $save_version->android_force_update = $request->android_force_update;

        $save_version->save();
        return redirect()->route('appversion')->with('success', 'Data saved successfully !!!');
    }
}
