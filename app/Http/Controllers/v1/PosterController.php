<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\UserDeviceToken;
use App\Models\Poster;
use Auth;
use DB;
use Hash;
use JWTAuth;
use Session;

class PosterController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';
            
    /*******************   START : Business details    ********************/
    public function getPosterList() {
        try {
            $userId = Auth::User()->id;

            $poster = Poster::where('status', 'active');
            
            $total_poster = $poster->count();
            if (isset($request->offset) && isset($request->limit)) {
                $poster = $poster->skip($request->offset)->take($request->limit)->get();
            } else {
                $poster = $poster->get();
            }

            if(!$poster->isEmpty()) {
                foreach($poster as $key => $val) {
                    $val['poster_image'] = !empty($val->poster_image) ? asset('public/uploads/posters/' . $val->poster_image) : "";                    
                }
            }

            return response()->json(['message' => 'Poster List', 'total_poster' => $total_poster, 'data' => $poster], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : Business details    ********************/
        
}
