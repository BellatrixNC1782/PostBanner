<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cms;
use Redirect;
use App\Models\User;
use App\Models\Common;
use DB;

class CmsController extends Controller
{
    public $data = [];

    public function index() {
        $this->data['cmsdata'] = DB::table('cms as c')
            ->select('c.*')
            ->get();
        
        return view('admincp.cms.cms',$this->data);
    }
    
    

    public function getCms(Request $request) {
        $columns = array('id', 'document_name', 'document_type', 'updated_at');
        $getfiled = array('id', 'document_name', 'document_type', 'created_at', 'updated_at');
        $condition = array();
        $join_str = array();
        echo Cms::getCms('cms', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    
    public function addCms() {
        return view('admincp.cms.add');
    }
    public function saveCms(Request $request) {
        $rules = array(
            'document_name' => 'required|min:2|max:32',
            'document_type' => 'required|unique:cms,document_type',
            'document_file' => 'required|min:20',
        );
        $messages = array(
            'document_name.required' => 'Please enter document name',
            'document_name.min' => 'Please enter minimum 2 characters of document name',
            'document_name.max' => 'Please enter document name in 32 charactors',
            'document_file.required' => 'Please enter description',
            'document_file.min' => 'Description should be min 20  characters',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        $save_cms = new Cms();
        $save_cms->document_name = $request->document_name;
        $save_cms->document_type = $request->document_type;
        $save_cms->document_file = $request->document_file;
        $save_cms->slug_url = str_replace(" ","_",strtolower($request->document_type));

        $save_cms->save();
        
        return redirect()->route('cms')->with('success', 'Cms added successfully');
    }
    
    
    public function editCms($id) {
        $cms_detail = Cms::find($id);
        if (!$cms_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['cms'] = $cms_detail;
        return view('admincp.cms.edit', $this->data);
    }

    public function updateCms(Request $request) {
        $rules = array(
            'document_name' => 'required|min:2|max:32',
            'document_type' => 'required|unique:cms,document_type,'.base64_decode($request->cms_id),
            'document_file' => 'required|min:20',
        );
        $messages = array(
            'document_name.required' => 'Please enter document name',
            'document_name.min' => 'Please enter minimum 2 characters of document name',
            'document_name.max' => 'Please enter document name in 32 charactors',
            'document_file.required' => 'Please enter description',
            'document_file.min' => 'Description should be min 20  characters',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $save_cms = Cms::find(base64_decode($request->cms_id));
        if (!$save_cms) {
            return redirect()->back()->with('error', 'Information not found');
        }
        
        $save_cms->document_name = $request->document_name;
        $save_cms->document_file = $request->document_file;
        $save_cms->save();
        return redirect()->route('cms')->with('success', 'Cms updated successfully');
    }
    
    public function cmsDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $cmsDetail = Cms::find($id);
            if (!$cmsDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $cmsDetail;
            $html = view('admincp.cms.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function deleteCms(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $settingDetail = Cms::find(base64_decode($request->serviceId));
            if (!$settingDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if (Cms::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'CMS deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }
}
