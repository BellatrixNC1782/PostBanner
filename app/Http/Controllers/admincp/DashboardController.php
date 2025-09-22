<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public $data = [];
    
    public function index(Request $request) {
        
        
        $this->data['total_users'] = User::where('email_verify','Yes')->get()->count();
        
        
        $yearData = DB::table('users')
            ->select(DB::raw('EXTRACT(YEAR FROM created_at) as year'))
            ->whereNotNull('created_at')
            ->whereNull('deleted_at')
            ->where('email_verify','Yes')
            ->groupBy('year')
            ->orderBy('year','ASC')
            ->get()->first();
        $year = [];
        if(!empty($yearData)){
            if($yearData->year <= date('Y')){
                for($i = $yearData->year;$i <= date('Y');$i++){
                    array_unshift($year,$i);
                }
            }
        }
        
        

        $this->data['year'] = $year;
        
//        dd($this->data);
               
        return view('admincp.dashboard.dashboard', $this->data);
    }
    
    public function getuserchart(Request $request,$year){
        $user_graph = array();
		
		$userData =  DB::table('users')
			->selectRaw('EXTRACT(MONTH FROM created_at) as month')
			->selectRaw('count(*) as count')
			->whereYear('created_at', '=',$year)
            ->whereNotNull('created_at')
            ->whereNull('deleted_at')
            ->where('email_verify','Yes')
			->groupBy('month')
			->orderBy('month')
			->pluck('count', 'month')->toArray();
        
        
		
    	$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		$userArr = [];

		for ($i = 1; $i <= 12; $i++) {
			if (!empty($userData[$i])) {
				$userArr[$month[$i - 1]] = $userData[$i];
			} else {
				$userArr[$month[$i - 1]] = 0;
			}
		}
        
		$user_graph['month_wise_user_label'] = array_keys($userArr);
		$user_graph['month_wise_user_count'] = array_values($userArr);

		 return response()->json(['status'=>'sucess','response'=>$user_graph]);
    }
    
    public function getVideoChart(Request $request,$year){
        $earning_graph = array();
		
		$earningData =  DB::table('video_purchase_transaction')
			->selectRaw('month(created_at) as month')
			->selectRaw('sum(amount) as amount_count')
            ->whereYear('created_at','=',$year)
			->groupBy(['month'])
			->orderBy('month')
			->pluck('amount_count','month')->toArray();
 
    	$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		$earningArr = [];

		for ($i = 1; $i <= 12; $i++) {
			if (!empty($earningData[$i])) {
				$earningArr[$month[$i - 1]] = $earningData[$i];
			} else {
				$earningArr[$month[$i - 1]] = 0;
			}
		}
        
		$earning_graph['month_wise_video_earning_label'] = array_keys($earningArr);
		$earning_graph['month_wise_video_earning_count'] = array_values($earningArr);

		 return response()->json(['status'=>'sucess','response'=>$earning_graph]);
    } 
    
    public function getSubscriptionChart(Request $request,$year){
        $earning_graph = array();
		
		$earningData =  DB::table('service_plan_transaction')
			->selectRaw('month(created_at) as month')
			->selectRaw('sum(amount) as amount_count')
            ->whereYear('created_at','=',$year)
			->groupBy(['month'])
			->orderBy('month')
			->pluck('amount_count','month')->toArray();
 
    	$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		$earningArr = [];

		for ($i = 1; $i <= 12; $i++) {
			if (!empty($earningData[$i])) {
				$earningArr[$month[$i - 1]] = $earningData[$i];
			} else {
				$earningArr[$month[$i - 1]] = 0;
			}
		}
        
		$earning_graph['month_wise_subscription_earning_label'] = array_keys($earningArr);
		$earning_graph['month_wise_subscription_earning_count'] = array_values($earningArr);

		 return response()->json(['status'=>'sucess','response'=>$earning_graph]);
    }
}
