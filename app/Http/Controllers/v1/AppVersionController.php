<?php

namespace App\Http\Controllers\v1;

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
    
    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';
        
    /********************   START : Get user profile detail     *********************/  
    public function getAppVersion() {
        try {                        
            $data = AppVersion::first();
            
            return response()->json(['message' => 'App version details','data' => $data], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Get user profile detail     *********************/
}
