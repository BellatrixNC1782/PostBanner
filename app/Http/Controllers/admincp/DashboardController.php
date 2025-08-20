<?php

namespace App\Http\Controllers\admincp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PlaceOrder;
use App\Models\UserAlumniInformations;
use App\Models\Transaction;
use App\Models\Interaction;
use App\Models\FanBookingSession;
use DB;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller {

    public $data = [];

    public function index(Request $request) {
        $this->data['total_fan'] = User::where('users.role_id', 2)
                ->join('user_colors', 'user_colors.user_id', 'users.id')
                ->whereNull('users.deleted_at')
                ->get()->count();
        $this->data['total_alumni'] = User::where('users.role_id', 1)
                ->leftjoin('user_alumni_informations', 'user_alumni_informations.user_id', 'users.id')
                ->whereNull('users.deleted_at')
                ->where(function ($query) {
                    $query->where('users.mobile_verify','Yes')
                          ->orWhere('users.email_verify', 'Yes');
                })
                ->get()->count();
        $this->data['total_order'] = PlaceOrder::get()->count();
        
        $this->data['id_verify_pending'] = UserAlumniInformations::join('users', 'users.id', 'user_alumni_informations.user_id')
                ->whereNull('users.deleted_at')
                ->whereNotNull('user_alumni_informations.alumni_identity')
                ->where('user_alumni_informations.identity_status', 'pending')->get()->count();
        
        $this->data['subscribed_user'] = Transaction::join('users', 'users.id', 'subscription_transactions.user_id')
            ->join('subscription_plans', 'subscription_plans.id', 'subscription_transactions.subscription_plan_id')
            ->join('user_roles', 'user_roles.id', 'subscription_transactions.role_id')
            ->where('subscription_transactions.endDate','>=',date('Y-m-d H:i:s'))
            ->where('subscription_transactions.txtId', '!=', 'free_trial')
            ->whereNull('users.deleted_at')
            ->groupBy('subscription_transactions.user_id', 'subscription_transactions.role_id')->get()->count();
        
        $this->data['completed_quiz'] = Interaction::where('type', 'quiz')->whereDate('to_date_time', '<', now())->count();
        $this->data['completed_question'] = Interaction::where('type', 'question_answer')->whereDate('to_date_time', '<', now())->get()->count();
        $this->data['completed_contest'] = Interaction::where('type', 'contest')->whereDate('to_date_time', '<', now())->get()->count();
        $this->data['total_order_earning'] = PlaceOrder::get()->map(function ($order) { return $order->price - $order->final_transaction_charges; })->sum();
        $this->data['total_booking_earning'] = FanBookingSession::where('is_refund', '!=', '1')->whereIn('status', ['accepted', 'completed', 'cancelled'])
                ->whereNotNull('transactionDate')->get()->map(function ($booking) { return $booking->fpl_getting_amount + $booking->fpl_charges - $booking->final_transaction_charges; })->sum();
        $this->data['total_subscription_earning'] = Transaction::where('txtId', '!=', 'free_trial')->get()->map(function ($subscription) { return $subscription->amount; })->sum();
        
        $this->data['subscribed_fan'] = Transaction::join('users', 'users.id', 'subscription_transactions.user_id')
            ->join('subscription_plans', 'subscription_plans.id', 'subscription_transactions.subscription_plan_id')
            ->join('user_roles', 'user_roles.id', 'subscription_transactions.role_id')
            ->where('subscription_transactions.endDate','>=',date('Y-m-d H:i:s'))
            ->where('subscription_transactions.txtId', '!=', 'free_trial')
            ->where('subscription_transactions.role_id', 2)
            ->whereNull('users.deleted_at')
            ->groupBy('subscription_transactions.user_id', 'subscription_transactions.role_id')->get()->count();
        $this->data['subscribed_alumni'] = Transaction::join('users', 'users.id', 'subscription_transactions.user_id')
            ->join('subscription_plans', 'subscription_plans.id', 'subscription_transactions.subscription_plan_id')
            ->join('user_roles', 'user_roles.id', 'subscription_transactions.role_id')
            ->where('subscription_transactions.endDate','>=',date('Y-m-d H:i:s'))
            ->where('subscription_transactions.txtId', '!=', 'free_trial')
            ->where('subscription_transactions.role_id', 1)
            ->whereNull('users.deleted_at')
            ->groupBy('subscription_transactions.user_id', 'subscription_transactions.role_id')->get()->count();
        
        // Users year
        $userYears = User::join('user_colors', 'user_colors.user_id', '=', 'users.id')
                        ->whereNotNull('users.created_at')
                        ->where('users.role_id', 2)
                        ->select(DB::raw('YEAR(users.created_at) as year'))
                        ->groupBy('year')
                        ->orderBy('year', 'ASC')
                        ->pluck('year')
                ->toArray();

        $alumniYears = User::join('user_alumni_informations', 'user_alumni_informations.user_id', '=', 'users.id')
                        ->whereNull('users.deleted_at')
                        ->whereNotNull('user_alumni_informations.alumni_identity')
                        ->whereNotNull('users.created_at')
                        ->where('users.role_id', 1)
                        ->select(DB::raw('YEAR(users.created_at) as year'))
                        ->groupBy('year')
                        ->orderBy('year', 'ASC')
                        ->pluck('year')->toArray();

        $allUserYears = array_merge($userYears, $alumniYears);
        $allUserYears = array_unique($allUserYears);
        sort($allUserYears);

        $year = [];
        if (!empty($allUserYears)) {
            $startYear = min($allUserYears);
            $endYear = date('Y');

            for ($i = $startYear; $i <= $endYear; $i++) {
                $year[] = $i;
            }
        }

        $this->data['year'] = $year;

        $pryearData = DB::table('interactions')
                        ->select(DB::raw('YEAR(from_date_time) as year'))
                        ->where('from_date_time', '!=', null)
                        ->groupBy('year')
                        ->orderBy('year', 'ASC')
                        ->get()->first();

        $pryear = [];
        if (!empty($pryearData)) {
            if ($pryearData->year <= date('Y')) {
                for ($i = $pryearData->year; $i <= date('Y'); $i++) {
                    array_unshift($pryear, $i);
                }
            }
        }
        $this->data['pryear'] = $pryear;
        
        $orders = PlaceOrder::select(DB::raw('YEAR(created_at) as year'))
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->get()->first();

        $oyear = [];
        if (!empty($orders)) {
            if ($orders->year <= date('Y')) {
                for ($i = $orders->year; $i <= date('Y'); $i++) {
                    array_unshift($oyear, $i);
                }
            }
        }
        $this->data['oyear'] = $oyear;
        
        $subscribed_user = Transaction::select(DB::raw('YEAR(subscription_transactions.created_at) as year'))
            ->where('subscription_transactions.txtId', '!=', 'free_trial')
            ->groupBy('year')
            ->orderBy('year', 'ASC')->get()->first();   

        $syear = [];
        if (!empty($subscribed_user)) {
            if ($subscribed_user->year <= date('Y')) {
                for ($i = $subscribed_user->year; $i <= date('Y'); $i++) {
                    array_unshift($syear, $i);
                }
            }
        }     
        $this->data['syear'] = $syear;
        
        // Get distinct years from fan_booking_sessions table
        $fanYears = DB::table('fan_booking_sessions')
                        ->select(DB::raw('YEAR(transactionDate) as year'))
                        ->where('transactionDate', '!=', null)
                        ->where('is_refund', '!=', '1')
                        ->whereIn('status', ['accepted', 'completed', 'cancelled'])
                        ->groupBy(DB::raw('YEAR(transactionDate)'))
                        ->orderBy('year', 'ASC')
                        ->pluck('year')->toArray();

        // Get distinct years from place_order table
        $orderYears = DB::table('place_order')
                        ->select(DB::raw('YEAR(transactionDate) as year'))
                        ->where('transactionDate', '!=', null)
                        ->groupBy(DB::raw('YEAR(transactionDate)'))
                        ->orderBy('year', 'ASC')
                        ->pluck('year')->toArray();

        // Merge years from both tables and remove duplicates
        $allYears = array_merge($fanYears, $orderYears);
        $allYears = array_unique($allYears);
        sort($allYears);
        $fyear = [];
        if(!empty($allYears)){
            $startYear = min($allYears);
            $endYear = date('Y');

            for ($i = $startYear; $i <= $endYear; $i++) {
                $fyear[] = $i;
            }
        }

        // Return the year list to the view
        $this->data['fyear'] = $fyear;

        return view('admincp.dashboard.dashboard', $this->data);
    }

    public function addcurrentusertimezone(Request $request) {
        try {
            $userId = Auth::guard('admin')->User()->id;
            DB::table('admins')->where('id', $userId)->update(['time_zone' => $request->timezone]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        return response()->json(['status' => 'success', 'message' => 'success']);
    }
    
    public function getuserchart(Request $request, $year) {
        $user_graph = [];

        // Query for user counts
        $userData = User::selectRaw('month(users.created_at) as month')
                        ->join('user_colors', 'user_colors.user_id', 'users.id')
                        ->whereNull('users.deleted_at')
                        ->selectRaw('count(*) as count')
                        ->whereYear('users.created_at', '=', $year)
                        ->whereNotNull('users.created_at')
                        ->where('users.role_id', 2) // Assuming role_id 2 is for users
                        ->groupBy('month')
                        ->orderBy('month')
                        ->pluck('count', 'month')->toArray();

        // Query for alumni counts
        $alumniData = User::selectRaw('month(users.created_at) as month')
                        ->join('user_alumni_informations', 'user_alumni_informations.user_id', 'users.id')
                        ->whereNull('users.deleted_at')
                        ->whereNotNull('user_alumni_informations.alumni_identity')
                        ->selectRaw('count(*) as count')
                        ->whereYear('users.created_at', '=', $year)
                        ->whereNotNull('users.created_at')
                        ->where('users.role_id', 1) // Assuming role_id 1 is for alumni
                        ->groupBy('month')
                        ->orderBy('month')
                        ->pluck('count', 'month')->toArray();

        // Month labels
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $userArr = array_fill_keys($month, 0);
        $alumniArr = array_fill_keys($month, 0);

        // Populate user counts
        foreach ($userData as $monthIndex => $count) {
            $userArr[$month[$monthIndex - 1]] = $count; // monthIndex is 1-based
        }

        // Populate alumni counts
        foreach ($alumniData as $monthIndex => $count) {
            $alumniArr[$month[$monthIndex - 1]] = $count; // monthIndex is 1-based
        }

        // Build the response array
        $user_graph = [
            'month_wise_user_label' => array_keys($userArr),
            'month_wise_user_count' => array_values($userArr),
            'month_wise_alumni_count' => array_values($alumniArr) // Changed to match frontend expectation
        ];

        return response()->json(['status' => 'success', 'response' => $user_graph]);
    }

    public function getQuizData($year, $month, $type) {
        // Start and end of the month
        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();
        if($type == 'quiz') {
            // Get quiz data for the specified month based on from_date_time
            $quizData = DB::table('quiz_answers')
                    ->select(
                            DB::raw('DATE(interactions.from_date_time) as day'), // Change to from_date_time
                            'interactions.question',
                            DB::raw('COUNT(quiz_answers.id) as played_count')
                    )
                    ->join('interactions', 'quiz_answers.interaction_id', '=', 'interactions.id')
                    ->where('interactions.type', $type)
                    ->whereBetween('interactions.from_date_time', [$startDate, $endDate]) // Change to from_date_time
                    ->groupBy('day', 'interactions.id') // Group by day and quiz ID
                    ->orderBy('day')
                    ->get();            
        }
        if($type == 'question_answer') {
            // Get quiz data for the specified month based on from_date_time
            $quizData = DB::table('question_answers_messages')
                    ->select(
                            DB::raw('DATE(interactions.from_date_time) as day'), // Change to from_date_time
                            'interactions.question',
                            DB::raw('COUNT(question_answers_messages.id) as played_count')
                    )
                    ->join('interactions', 'question_answers_messages.question_answer_id', '=', 'interactions.id')
                    ->where('interactions.type', $type)
                    ->whereBetween('interactions.from_date_time', [$startDate, $endDate]) // Change to from_date_time
                    ->groupBy('day', 'interactions.id', 'question_answers_messages.from_id') // Group by day and quiz ID
                    ->orderBy('day')
                    ->get();            
        }
        if($type == 'contest') {
            // Get quiz data for the specified month based on from_date_time
            $quizData = DB::table('contests_messages')
                    ->select(
                            DB::raw('DATE(interactions.from_date_time) as day'), // Change to from_date_time
                            'interactions.question',
                            DB::raw('COUNT(contests_messages.id) as played_count')
                    )
                    ->join('interactions', 'contests_messages.contest_id', '=', 'interactions.id')
                    ->where('interactions.type', $type)
                    ->whereBetween('interactions.from_date_time', [$startDate, $endDate]) // Change to from_date_time
                    ->groupBy('day', 'interactions.id') // Group by day and quiz ID
                    ->orderBy('day')
                    ->get();            
        }

        // Prepare data in a structure that the frontend expects
        $formattedData = [];
        foreach ($quizData as $data) {
            $day = Carbon::parse($data->day)->day; // Get day of the month
            $formattedData[$day][] = [
                'quiz' => $data->question,
                'count' => $data->played_count
            ];
        }

        // Return JSON response with formatted data
        return response()->json([
                    'status' => true,
                    'data' => $formattedData
        ]);
    }
    
    public function getDailyOrdersData($year, $month) {
        // Start and end of the month
        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        // Get the daily total order amount for the specified month and year
        $orders = PlaceOrder::select(DB::raw('DATE(transactionDate) as day'), DB::raw('COUNT(*) as order_count'))
                ->whereBetween('transactionDate', [$startDate, $endDate])
                ->groupBy('day')
                ->orderBy('day')
                ->get();

        // Prepare the data in a structure that the frontend expects
        $formattedData = [];
        foreach ($orders as $order) {
            $day = Carbon::parse($order->day)->day; // Get the day of the month
            $formattedData[$day] = $order->order_count; // Store the total order amount for that day
        }

        return response()->json(['status' => true, 'data' => $formattedData]);
    }

    public function getSubscriptionData($year, $month) {
        // Start and end of the month
        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        // Get subscription data grouped by day for both alumni and fan roles
        $subscriptionData = Transaction::select(
                        DB::raw('DATE(startDate) as day'), // Extract the day from the start date
                        'role_id',
                        DB::raw('COUNT(id) as count') // Count the number of users
                )
                ->whereBetween('startDate', [$startDate, $endDate])
                ->where('txtId', '!=', 'free_trial')
//                ->where('is_active', 1) // Only active subscriptions
                ->groupBy('day', 'role_id') // Group by day and role_id
                ->orderBy('day')
                ->get();

        // Format data for the chart (separate for alumni and fan)
        $formattedData = [
            'alumni' => [],
            'fan' => []
        ];

        foreach ($subscriptionData as $data) {
            $day = Carbon::parse($data->day)->day; // Get day of the month

            if ($data->role_id == 1) { // Assuming role_id 1 is alumni
                $formattedData['alumni'][$day] = $data->count;
            } elseif ($data->role_id == 2) { // Assuming role_id 2 is fan
                $formattedData['fan'][$day] = $data->count;
            }
        }

        // Prepare data to return
        return response()->json([
                    'status' => true,
                    'data' => $formattedData
        ]);
    }
    
    public function getFplEarningsData($year, $month) {
        // Calculate start and end of the selected month
        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        // Query the fan_booking_sessions table for FPL-related charges and get combined "Booking Earnings"
        $fplData = FanBookingSession::select(
                        DB::raw('SUM(fpl_charges + fpl_getting_amount - final_transaction_charges) as total_booking_earnings') // Sum both values
                )
                ->where('is_refund', '!=', '1')
                ->whereIn('status', ['accepted', 'completed', 'cancelled'])
                ->whereBetween('transactionDate', [$startDate, $endDate])
                ->whereNotNull('transactionDate')
                ->first();

        // Query the place_order table for order earnings (price minus final_transaction_charges)
        $orderData = DB::table('place_order')
                ->select(
                        DB::raw('SUM(price - final_transaction_charges) as total_order_earnings')
                )
                ->whereBetween('transactionDate', [$startDate, $endDate])
                ->first();

        // Prepare the data for the doughnut chart
        $formattedData = [
            'booking_earnings' => $fplData ? $fplData->total_booking_earnings : 0,
            'order_earnings' => $orderData ? $orderData->total_order_earnings : 0
        ];

        // Return JSON response with formatted data
        return response()->json([
                    'status' => true,
                    'data' => $formattedData
        ]);
    }

}
