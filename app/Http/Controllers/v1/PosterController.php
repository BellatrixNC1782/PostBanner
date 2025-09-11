<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\UserDeviceToken;
use App\Models\Poster;
use App\Models\Category;
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
            
    /*******************   START : Poster List    ********************/
    public function getPosterList(Request $request) {
        try {
            $poster = Poster::select('posters.*', 'categories.name')
                        ->join('categories', 'categories.id', 'posters.category_id')
                        ->where('posters.status', 'active');
            
            if(isset($request->category_id) || $request->category_id != '') {                
                $poster = $poster->where('posters.category_id', $request->category_id);
            }

            if (!empty($request->search)) {
                $poster->where('categories.name', 'LIKE', '%' . $request->search . '%');
            }

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
    /*******************   END : Poster List    ********************/
            
    /*******************   START : Category List    ********************/
    public function getCategoryList() {
        try {
            $category = Category::where('status', 'active');
            
            $total_category = $category->count();
            if (isset($request->offset) && isset($request->limit)) {
                $category = $category->skip($request->offset)->take($request->limit)->get();
            } else {
                $category = $category->get();
            }

            return response()->json(['message' => 'Category List', 'total_category' => $total_category, 'data' => $category], $this->successStatus);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /*******************   END : Category List    ********************/
        
}
