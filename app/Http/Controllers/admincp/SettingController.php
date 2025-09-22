<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Common;
use Validator;
use Hash;
use DB;
use Auth;

class SettingController extends Controller {

    public $data = [];
    
    /********************   START : Get setting list    *********************/
    public function settingList(Request $request) {
        return view('admincp.setting.setting');
    }
    /********************   END : Get setting list    *********************/
    public function getSettingList(Request $request) {
        $columns = array(
            's.id',
            's.setting_title',
            's.setting_key',
            's.setting_value',
            's.type',
            's.created_at',
            's.updated_at',
        );
        $getfiled = array(
            's.id',
            's.setting_title',
            's.setting_key',
            's.setting_value',
            's.type',
            's.created_at',
        );
        $condition = array();
        $join_str = array();
        
        echo Settings::getSetting('settings as s', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    /********************   END : Get setting list    *********************/    
    
    /********************   START : Add setting    *********************/
    public function addSetting(Request $request) {
        return view('admincp.setting.add', $this->data);
    }
    
    public function saveSetting(Request $request) {
        $messages = array(
            'setting_title.required' => 'The setting title is required.',
            'setting_value.required' => 'The setting value is required.'
        );
        $rules = array(
            'setting_title' => 'required',
            'setting_value' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $alias_names = str_replace(' ', '_', strtoupper($request->setting_title));
        $checkExist = Settings::where('setting_key',$alias_names)->get();
        
        if(!$checkExist->isEmpty()){
            return redirect()->back()->with('error', 'Setting title already exists.');
        }
        
        $savesetting = new Settings();
        $savesetting->setting_title = $request->setting_title;
        $savesetting->setting_key = $alias_names;
        $savesetting->alias_name = $alias_names;
        $savesetting->setting_value = $request->setting_value;
        $savesetting->type = $request->type;
        
        $savesetting->save();
        return redirect()->route('settinglist')->with('success', 'Setting added successfully');
    }
    /********************   END : Add setting    *********************/    
    
    /********************   START : Edit setting    *********************/
    public function editSetting($id) {
        $setting_detail = Settings::where('id',$id)->first();
        if (!$setting_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['setting'] = $setting_detail;        
        return view('admincp.setting.edit', $this->data);
    }
    
    public function updateSetting(Request $request) {
        $messages = array(
            'setting_title.required' => 'The setting title is required.',
            'setting_value.required' => 'The setting value is required.'
        );
        $rules = array(
            'setting_title' => 'required',
            'setting_value' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $edit_setting = Settings::where('id',base64_decode($request->settingId))->first();
        if (!$edit_setting) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $alias_names = str_replace(' ', '_', strtoupper($request->setting_title));
        $checkExist = Settings::where('setting_key', $alias_names)->where('id', '!=', $edit_setting->id)->get();

        if(!$checkExist->isEmpty()){
            return redirect()->back()->with('error', 'Setting title already exists.');
        }
        
        $edit_setting->setting_title = $request->setting_title;
        $edit_setting->setting_value = $request->setting_value;
        $edit_setting->type = $request->type;
       
        $edit_setting->save();
        return redirect()->route('settinglist')->with('success', 'Setting updated successfully');
    }
    /********************   END : Edit setting    *********************/    
    
}
