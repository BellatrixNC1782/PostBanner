<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;
use App\Models\Common;
use Validator;
use Hash;
use DB;
use Auth;

class EmailController extends Controller {

    public $data = [];
    
    /********************   START : Get email list    *********************/
    public function emailList(Request $request) {
        return view('admincp.email.email');
    }
    /********************   END : Get email list    *********************/
    public function getEmailList(Request $request) {
        $columns = array(
            'e.id',
            'e.subject',
            'e.alias',
            'e.created_at',
            'e.status',
        );
        $getfiled = array(
            'e.id',
            'e.subject',
            'e.alias',
            'e.created_at',
            'e.status',
        );
        $condition = array();
        $join_str = array(); 
        
        echo Email::getEmailList('email as e', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    /********************   END : Get email list    *********************/    
    
    /********************   START : Add email    *********************/
    public function addEmail(Request $request) {
        return view('admincp.email.add', $this->data);
    }
    
    public function saveEmail(Request $request) {
        $messages = array(
            'subject.required' => 'Please enter subject',
            'subject.min' => 'Please enter valid subject',
            'subject.max' => 'Please enter alias in :max',
            'subject.min' => 'Please enter valid subject',
            'subject.max' => 'Please enter subject in :max',
            'content.required' => 'Please enter content',
        );
        $rules = array(
            'subject' => 'required|min:2|max:750',
            'subject' => 'required|min:2|max:750',
            'content' => 'required|min:3',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        $alias_names = str_replace(' ', '_', strtolower($request->subject));
        $checkExist = Email::where('alias',$alias_names)->get();
        
        if(!$checkExist->isEmpty()){
            return redirect()->back()->with('error', 'Email subject already exists.');
        }
        
        $saveemail = new Email();
        $saveemail->subject = $request->subject;
        $saveemail->alias = $alias_names;
        $saveemail->subject = $request->subject;
        $saveemail->content = $request->content;
        
        $saveemail->save();
        return redirect()->route('emaillist')->with('success', 'Email added successfully');
    }
    /********************   END : Add email    *********************/    
    
    /********************   START : Edit email    *********************/
    public function editEmail($id) {
        $email_detail = Email::where('id',$id)->first();
        if (!$email_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['email'] = $email_detail;    
        return view('admincp.email.edit', $this->data);
    }
    
    public function updateEmail(Request $request) {
        $messages = array(
            'subject.required' => 'Please enter subject',
            'subject.min' => 'Please enter valid subject',
            'subject.max' => 'Please enter alias in :max',
            'subject.min' => 'Please enter valid subject',
            'subject.max' => 'Please enter subject in :max',
            'content.required' => 'Please enter content',
        );
        $rules = array(
            'subject' => 'required|min:2|max:750',
            'subject' => 'required|min:2|max:750',
            'content' => 'required|min:3',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {            
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $edit_email = Email::where('id',base64_decode($request->emailTemplateId))->first();
        if (!$edit_email) {
            return redirect()->back()->with('error', 'Information not found');
        }

        $alias_names = str_replace(' ', '_', strtolower($request->subject));
        $checkExist = Email::where('alias',$alias_names)->where('id', '!=', $edit_email->id)->get();

        if(!$checkExist->isEmpty()){
            return redirect()->back()->with('error', 'Email Name already exists.');
        }
        
        $edit_email->subject = $request->subject;
        $edit_email->subject = $request->subject;
        $edit_email->content = $request->content;
       
        $edit_email->save();
        return redirect()->route('emaillist')->with('success', 'Email updated successfully');
    }
    /********************   END : Edit email    *********************/    
    
    /********************   START : Changes status/Delete email    *********************/
    public function changeEmailStatus(Request $request, $id) {
        
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Email::where('id',$id)->first();
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('admincp.email.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }
    public function updateEmailStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->emailTemplateId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Email::where('id',base64_decode($request->emailTemplateId))->first();
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if (Email::where('id',base64_decode($request->emailTemplateId))->update(array('deleted_at' => date('Y-m-d H:i:s')))) {
                return response()->json(['status' => 'success', 'message' => 'Email deleted successfully']);
            }
        }
        exit;
    }
    /********************   END : Changes status/Delete email    *********************/

}
