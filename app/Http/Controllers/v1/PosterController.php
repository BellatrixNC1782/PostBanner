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
use App\Models\Images;
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
                $poster = $poster->skip($request->offset)->take($request->limit)->orderBy('posters.id','desc')->get();
            } else {
                $poster = $poster->orderBy('posters.id','desc')->get();
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
    public function getCategoryList(Request $request) {
        try {
                $category = Category::select('id','name','image','date')->where('status', 'active');
                
                $total_category = $category->count();

                if ($request->filled(['country_code', 'start_date', 'end_date'])) {
                    $category = $category->where('county_code', $request->country_code);

                    if ($request->start_date === $request->end_date) {
                        // Same day → exact match
                        $category = $category->whereDate('date', $request->start_date);
                    } else {
                        // Range
                        $category = $category->whereBetween('date', [$request->start_date, $request->end_date]);
                    }
                }

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
    
    /*******************   END : Category List    ********************/
    public function uploadImage(Request $request){
        $messages = array(
            'image.required' => 'Please select image.'
        );

        $rules = array(
            'image' => 'required'
        );        
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        
        $save_image = new Images();
        
        if ($request->hasFile('image')) {
            $result = Common::uploadSingleImage($request->image, 'images');

            if ($result['status'] == 0) {
                return response()->json(['message' => 'Result not found'], $this->failStatus);
            } else {
                $save_image->image_name = $result['data'];
                $save_image->image_url = asset('public/uploads/images/'.$result['data']);
            }
        }
        
        $save_image->save();
        
        return response()->json(['message' => 'Poster saved successfully!','image_url' => $save_image->image_url], $this->successStatus);
    }
    /*******************   END : Category List    ********************/
        
}
