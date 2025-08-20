<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Common;
use App\Models\Journals;
use App\Models\Client;
use App\Models\Transaction;
use Auth;
use DB;
use Hash;
use JWTAuth;
use Session;
use DateTime;
use Carbon\Carbon;

class DashboardController extends Controller {

    public $data = [];
    public $successStatus = 200;
    public $failStatus = 400;
    public $notFound = 404;
    public $internalServer = 500;
    public $noDataMessage = 'No data found';
    public $somethingWrongMessage = 'Something went wrong. please try again';
    public $dataExistMessage = 'Data already exist';
    public $dataSaveMessage = 'Data saved successfully';

    
    
    /********************   END : Get Dashboard    *********************/
    public function getDashboard(Request $request){
        $messages = array(
            'user_profile_id.required' => 'Please pass the user profie id.',
        );
        
       
        $rules = array(
            'user_profile_id' => 'required',
            'duration' => 'in:all_time,this_month'
        );
        
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return response()->json(['message' => $messages[0]], $this->failStatus);
            }
        }
        
        try {
            
            $data['message'] = 'Dashboard detail';
            
            $total_given = DB::table('transactions')
                ->select(DB::raw("SUM(remain_amount) as count"))
                ->where('transactions.user_profile_id',$request->user_profile_id)
                ->whereNull('transactions.deleted_at')
                ->where('transactions.type','gave');
            
            if(isset($request->duration) && $request->duration == 'this_month'){
                $from_date = date('Y-m-01');
                $to_date = date('Y-m-t');
                
                $total_given->whereDate('transactions.transaction_date', '>=', $from_date);
                $total_given->whereDate('transactions.transaction_date', '<=', $to_date);
                
            }
            
            $total_given = round($total_given->first()->count,2);
            
            $total_taken = DB::table('transactions')
                ->select(DB::raw("SUM(remain_amount) as count"))
                ->where('transactions.user_profile_id',$request->user_profile_id)
                ->whereNull('transactions.deleted_at')
                ->where('transactions.type','took');
            
            if(isset($request->duration) && $request->duration == 'this_month'){
                $from_date = date('Y-m-01');
                $to_date = date('Y-m-t');
                
                $total_taken->whereDate('transactions.transaction_date', '>=', $from_date);
                $total_taken->whereDate('transactions.transaction_date', '<=', $to_date);
                
            }
            
            $total_taken = round($total_taken->first()->count,2);
            
            $total_income = DB::table('journals')
                ->select(DB::raw("SUM(amount) as count"))
                ->where('journals.user_profile_id',$request->user_profile_id)
                ->whereNull('journals.deleted_at')
                ->where('journals.type','income');
            
            if(isset($request->duration) && $request->duration == 'this_month'){
                $from_date = date('Y-m-01');
                $to_date = date('Y-m-t');
                
                $total_income->whereDate('journals.transaction_date', '>=', $from_date);
                $total_income->whereDate('journals.transaction_date', '<=', $to_date);
                
            }
            
            $total_income = round($total_income->first()->count,2);
            
            $total_expence = DB::table('journals')
                ->select(DB::raw("SUM(amount) as count"))
                ->where('journals.user_profile_id',$request->user_profile_id)
                ->whereNull('journals.deleted_at')
                ->where('journals.type','expense');
            
            if(isset($request->duration) && $request->duration == 'this_month'){
                $from_date = date('Y-m-01');
                $to_date = date('Y-m-t');
                
                $total_expence->whereDate('journals.transaction_date', '>=', $from_date);
                $total_expence->whereDate('journals.transaction_date', '<=', $to_date);
                
            }
            
            $total_expence = round($total_expence->first()->count,2);
            $total_balance = round($total_income - $total_expence,2);
            
            
            $stats = [
                'total_given' => $total_given,
                'total_taken' => $total_taken,
                'total_income' => $total_income,
                'total_expence' => $total_expence,
                'total_balance' => $total_balance
            ];
            
            
            $data['stats'] = $stats;
            
            
            $resent_client = Client::select('clients.id as client_id','clients.client_name')
                    ->join('user_profiles', 'user_profiles.id', 'clients.user_profile_id')
                    ->orderBy('clients.id', 'desc')
                    ->where('clients.user_profile_id', $request->user_profile_id)
                    ->skip(0)
                    ->take(3)
                    ->get();
           
            
            if(!$resent_client->isEmpty()) {
                // Get all client IDs
                $clientIds = $resent_client->pluck('client_id')->toArray();

                // Fetch and group transactions by client_id and type
                $transactions = Transaction::select('client_id', 'type', DB::raw('SUM(remain_amount) as total'))
                        ->whereIn('client_id', $clientIds)
                        ->groupBy('client_id', 'type')
                        ->get()
                        ->groupBy('client_id');

                foreach ($resent_client as $val) {
                    $val->balance = $val->balance ?? 0;

                    $clientTrans = $transactions[$val->client_id] ?? collect();

                    $gave = $clientTrans->where('type', 'gave')->sum('total');
                    $took = $clientTrans->where('type', 'took')->sum('total');

                    $val->balance = round($val->balance - $gave + $took, 2);
                }
            }
            
            $data['clients'] = $resent_client;
            
            
            $startDate = now()->subMonths(5)->startOfMonth(); // include current month
            $endDate = now()->endOfMonth();

            $journal_insights = [];

            // Arrays with proper unique keys
            $base = Carbon::now()->startOfMonth(); // Set fixed reference point
            $monthLabels = [];
            $incomeArr = [];
            $expenseArr = [];

            for ($i = 0; $i < 6; $i++) {
                $month = $base->copy()->subMonths(5 - $i);
                $key = $month->format('Y-m'); // e.g., "2025-07"
                $label = $month->format('M'); // e.g., "Jul"

                $monthLabels[$key] = $label;
                $incomeArr[$key] = 0;
                $expenseArr[$key] = 0;
            }

            //print_r($monthLabels); die;

            // Fetch income data with unique Y-m keys
            $incomeData = Journals::selectRaw("TO_CHAR(transaction_date, 'YYYY-MM') as month_key")
                ->selectRaw('SUM(amount) as count')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->whereNotNull('created_at')
                ->where('type', 'income')
                ->where('user_profile_id', $request->user_profile_id)
                ->groupBy('month_key')
                ->pluck('count', 'month_key')
                ->toArray();

            // Fetch expense data with same keys
            $expenseData = Journals::selectRaw("TO_CHAR(transaction_date, 'YYYY-MM') as month_key")
                ->selectRaw('SUM(amount) as count')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->whereNotNull('created_at')
                ->where('type', 'expense')
                ->where('user_profile_id', $request->user_profile_id)
                ->groupBy('month_key')
                ->pluck('count', 'month_key')
                ->toArray();

            // Merge into income/expense arrays
            foreach ($incomeData as $monthKey => $count) {
                if (isset($incomeArr[$monthKey])) {
                    $incomeArr[$monthKey] = round($count, 2);
                }
            }
            foreach ($expenseData as $monthKey => $count) {
                if (isset($expenseArr[$monthKey])) {
                    $expenseArr[$monthKey] = round($count, 2);
                }
            }

            // Final journal_insights output
            $journal_insights = [];
            $i = 1;
            foreach ($monthLabels as $key => $label) {
                $journal_insights[] = [
                    'id' => $i++,
                    'name_of_month' => $label,
                    'income' => $incomeArr[$key],
                    'expense' => $expenseArr[$key],
                ];
            }

            $data['journal_insights'] = $journal_insights;           
            
            
            return response()->json($data, $this->successStatus);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $this->failStatus);
        }
    }
    /********************   END : Get Dashboard     *********************/
    
   
    
    
    
    
}
