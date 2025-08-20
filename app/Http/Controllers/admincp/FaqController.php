<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App\Models\Faq;

class FaqController extends Controller
{
    public $data = [];
    
    public function index() {
        return view('admincp.faq.faq');
    }
    
    public function getFaq(Request $request) {
        $columns = array('id', 'user_category', 'question', 'answer', 'updated_at', 'status');
        $getfiled = array('id', 'user_category', 'question', 'answer', 'created_at', 'updated_at', 'status');
        $condition = array();
        $join_str = array();
        echo Faq::getFaq('faq', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    
    public function addFaq(Request $request) {
        return view('admincp.faq.add');
    }
    
    public function saveFaq(Request $request) {
        
        $rules = array(
            'question' => 'required|min:2|max:250',
            'answer' => 'required|min:2|max:5000',
            'user_category' => 'required',
        );
        
        $messages = array(
            'question.required' => 'Please Enter Question',
            'question.min' => 'Question name should be minimum :min characters',
            'question.max' => 'Question name should be between 2 to 250 characters',
            'answer.required' => 'Please Enter Answer',
            'answer.min' => 'Answer name should be minimum :min characters',
            'answer.max' => 'Answer name should be between 2 to 5000 characters',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $savefaq = new Faq();
        $savefaq->question = $request->question;
        $savefaq->user_category = $request->user_category;
        $savefaq->answer = $request->answer;
        $savefaq->alias = str_replace(" ", "_", strtolower($request->question));
        
        $savefaq->save();
        return redirect()->route('faq')->with('success', 'FAQ added successfully');
    }
    
    public function editFaq($id) {
        $faq_detail = Faq::find($id);
        if (!$faq_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['faq'] = $faq_detail;
        
        return view('admincp.faq.edit', $this->data);
    }
    
    public function updateFaq(Request $request) {
        $rules = array(
            'question' => 'required|min:2|max:250',
            'answer' => 'required|min:2|max:5000',
            'user_category' => 'required',
        );
        
        $messages = array(
            'question.required' => 'Please Enter Question',
            'question.min' => 'Question name should be minimum :min characters',
            'question.max' => 'Question name should be between 2 to 250 characters',
            'answer.required' => 'Please Enter Answer',
            'answer.min' => 'Answer name should be minimum :min characters',
            'answer.max' => 'Answer name should be between 2 to 5000 characters',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $edit_page = Faq::find(base64_decode($request->faq_id));
        if (!$edit_page) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $edit_page->question = $request->question;
        $edit_page->user_category = $request->user_category;
        $edit_page->answer = $request->answer;
        
        $edit_page->save();
        return redirect()->route('faq')->with('success', 'FAQ updated successfully');
    }
    
    public function faqDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $faqDetail = Faq::find($id);
            if (!$faqDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $faqDetail;
            $html = view('admincp.faq.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function deleteFaq(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $settingDetail = Faq::find(base64_decode($request->serviceId));
            if (!$settingDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if (Faq::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'FAQ deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

    public function changeFaqStatus(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Faq::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('admincp.faq.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function updateFaqStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Faq::find(base64_decode($request->serviceId));
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if ($changeStatus->status == 'active') {
                $changeStatus->status = 'inactive';
            } else {
                $changeStatus->status = 'active';
            }
            if (!$changeStatus->save()) {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            return response()->json(['status' => 'success', 'message' => "Status change successfully"]);
        }
        exit;
    }
}
