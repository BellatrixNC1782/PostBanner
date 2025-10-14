<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\SavedPoster;
use App\Models\BusinessProfile;
use Auth;
use DB;
use Hash;
use JWTAuth;
use Session;

class SavedPosterController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';
    
    /********************   START : Add/Update Saved Poster    *********************/
    public function addUpdateSavedPoster(Request $request) {
        
        $messages = array(
            'image.required' => 'Please enter your profile name.',
            'poster_json.required' => 'Please enter your poster json.',
        );

        $rules = array(
            'image' => 'required',
            'poster_json' => 'required',
        );        
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        
        $user_id = Auth::User()->id;
                
        if(isset($request->saved_poster_id) && !empty($request->saved_poster_id)) {
            $save_saved_poster = SavedPoster::find($request->saved_poster_id);
            if(empty($save_saved_poster)) {
                return response()->json(['message' => 'Please pass valid saved poster id'], $this->failStatus);
            }
        }else{
            $save_saved_poster = new SavedPoster();
        }
        $save_saved_poster->user_id = $user_id;
        
        if(isset($request->business_id) || $request->business_id != '') {
            $save_saved_poster->business_id = $request->business_id;
            $business_detail_check = BusinessProfile::where('id', $request->business_id)->where('user_id', $user_id)->first();
            if(empty($business_detail_check)) {
                return response()->json(['message' => 'Business detail not found'], $this->failStatus);
            }            
        }
        $save_saved_poster->poster_json = $request->poster_json;
        
        if ($request->hasFile('image')) {
            $result = Common::uploadSingleImage($request->image, 'saved_poster');

            if ($result['status'] == 0) {
                return response()->json(['message' => 'Result not found'], $this->failStatus);
            } else {
                $save_saved_poster->image = $result['data'];
            }
        }
        $save_saved_poster->save();        
               
        DB::beginTransaction();
        try {        
            return response()->json(['message' => 'Poster saved successfully!'], $this->successStatus);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
        return response()->json(['message' => 'Something went wrong. please try again'], $this->internalServer);
    }
    /********************   END : Add/Update Saved Poster    *********************/
            
    /*******************   START : Saved Poster List    ********************/
    public function getSavedPosterlist(Request $request) {
        try {
            $userId = Auth::User()->id;

            $saved_poster = SavedPoster::select('saved_posters.*', 'business_details.type', 'business_details.user_name', 'business_details.business_name', 
                    'business_details.email', 'business_details.mobile', 'business_details.image as business_image')
                    ->leftjoin('business_details', 'business_details.id', 'saved_posters.business_id')
                    ->where('saved_posters.user_id', $userId);
            
            $total_poster = $saved_poster->count();
            if (isset($request->offset) && isset($request->limit)) {
                $saved_poster = $saved_poster->skip($request->offset)->take($request->limit)->orderBy('saved_posters.id','desc')->get();
            } else {
                $saved_poster = $saved_poster->orderBy('saved_posters.id','desc')->get();
            }

            if(!$saved_poster->isEmpty()) {
                foreach($saved_poster as $key => $val) {
                    $val['image'] = !empty($val->image) ? asset('public/uploads/saved_poster/' . $val->image) : "";
                    $val['business_image'] = !empty($val->business_image) ? asset('public/uploads/user_profile/' . $val->business_image) : "";
                }
            }

            return response()->json(['message' => 'Saved poster detail', 'total_poster' => $total_poster, 'data' => $saved_poster], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : Saved Poster List    ********************/
    
    /********************   START : Delete Saved Poster     *********************/
    public function deleteSavedPoster($saved_poster_id) {
        try {

            $id = Auth::User()->id;

            $saved_poster = SavedPoster::where('user_id', $id)->where('id', $saved_poster_id)->first();

            if (empty($saved_poster)) {
                return response()->json(['message' => $this->noDataMessage], $this->failStatus);
            }

            $saved_poster->delete();

            return response()->json(['message' => 'Saved Poster successfully deleted'], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Delete Saved Poster     *********************/
        
}
