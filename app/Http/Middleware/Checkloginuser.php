<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\AlumniUserTeam;
use App\Models\UserColor;
use App\Models\AlumniService;
use App\Models\AlumniSession;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserAlumniInformations;
use App\Models\Common;
use Auth;

class Checkloginuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset(Auth::User()->id)) {
            if (Auth::User()->status != 'active') {
                $config = Settings::where('alias_name', 'SITE_EMAIL')->get();
                Auth::logout();

                return redirect()->route('login')->with('error', 'Your FPL account has been deactivated. For more information, please contact us at ' . $config[0]->SettingValue . '.');
            }

            $user = \DB::table('users')->where('id', Auth::user()->id)->first();
            $userId = $user->id;
            
            $color = UserColor::select('color_selection_1', 'color_selection_2')->where('user_id', $userId)->first();
            $color_selection_1 = !empty($color) ? $color->color_selection_1 : null;
            $color_selection_2 = !empty($color) ? $color->color_selection_2 : null;
            
            if (Auth::User()->mobile_verify != 'Yes') {
                if (Route::currentRouteName() != 'verificationmobile') {
                    return redirect()->route('verificationmobile')->with('error', 'Phone number verification is pending');
                }
            }
            
            $is_email_mendatory = 'no';
            $email = Common::getSetting('IS_EMAIL_MANDATORY'); 
            if(!empty($email)) {
                $is_email_mendatory = $email;            
            }
            $this->data['is_email_mendatory'] = $is_email_mendatory;
            if(!empty(Auth::User()->email) && Auth::User()->email_verify != 'Yes' && $is_email_mendatory == 'yes') {
                if (Route::currentRouteName() != 'verificationemail') {
                    return redirect()->route('verificationemail')->with('error', 'Email verification is pending');
                }
            }

            if(Auth::User()->role_id == 1) {
                                      
                $check_subscription = Common::getSetting('HIDE_ALUMNI_SUBSCRIPTION');
                $subscription_hide = 'yes';
                if (!empty($check_subscription)) {
                    $subscription_hide = $check_subscription;
                }
                // Subscription flag
                $date = strtotime(date('Y-m-d H:i:s'));
                $subscription = Transaction::select('endDate')->where('user_id', $userId)->orderBy('id', 'desc')->first();
                $isSubscription = 1;
                if (!empty($subscription) && $subscription_hide == 'no') {
                    $endDate1 = $subscription->endDate;
                    $startDate = strtotime($endDate1);

                    $interval = $startDate - $date;

                    if ($interval <= 0) {
                        $isSubscription = 0;
//                        dd(Route::currentRouteName());
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getsubscriptionplans')->with('error', 'Please subscribe');
                        }
                    }
                } else {
                    if ($subscription_hide == 'no') {
                        $isSubscription = 0;
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getsubscriptionplans')->with('error', 'Please subscribe');
                        }                        
                    }
                }
                
                if($isSubscription == 1) {                    
                    $alumni_detail = UserAlumniInformations::where('user_id', $userId)->first();
                    if (empty($alumni_detail)) {
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getaboutalumni')->with('error', 'Please complete you profile');                        
                        }
                    }
                
                    if(empty($color_selection_1) || empty($color_selection_2)) {
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getaboutalumni2')->with('error', 'Please complete you profile');
                        }
                    }
//                dd($isSubscription);
                    //Service
                    $alumni_service = AlumniService::where('user_id', $userId)->get();
                    $isServiceAdded = 0;
                    if (!$alumni_service->isEmpty()) {
                        $alumni_session = AlumniService::join('services', 'services.id', 'alumni_services.service_id')
                                ->where('alumni_services.user_id', $userId)
                                ->whereIn('services.alias', ['1:1_chat_session', 'video_shoutouts'])
                                ->get();

                        if (!$alumni_session->isEmpty()) {
                            $unfilled_session = AlumniSession::where('user_id', $userId)->get();
                            $isServiceAdded = $unfilled_session->isEmpty() ? 0 : 1;
                        } else {
                            $other_service = AlumniService::join('services', 'services.id', 'alumni_services.service_id')
                                    ->where('alumni_services.user_id', $userId)
                                    ->whereNotIn('services.alias', ['1:1_chat_session', 'video_shoutouts'])
                                    ->exists();

                            $isServiceAdded = $other_service ? 1 : 0;
                        }
                    }
                    if($isServiceAdded == 0) {
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getbusinessopportunity')->with('error', 'Please complete you profile');                       
                        }
                    }

                    //Session
                    $session = AlumniSession::where('user_id', $userId)->get();
                    $alumni_session = AlumniService::join('services', 'services.id', 'alumni_services.service_id')
                                    ->where('services.alias', '1:1_chat_session')
                                    ->orWhere('services.alias', 'video_shoutouts')
                                    ->where('user_id', $userId)->get();
                    $isSessionAdded = 0;
                    if (!empty($alumni_detail)) {
                        if (!$session->isEmpty()) {
                            $isSessionAdded = 1;
                        } else {
                            if (!$alumni_session->isEmpty()) {
                                $isSessionAdded = 1;
                            }
                        }
                    }
                    if($isSessionAdded == 0) {
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getbusinessopportunity')->with('error', 'Please complete you profile');                        
                        }
                    }

                    //ID photo
                    $isIDAdded = 0;
                    if (!empty($alumni_detail)) {
                        if (!empty($alumni_detail->alumni_identity)) {
                            $isIDAdded = 1;
                        }
                    }
                    if($isIDAdded == 0) {
                        if (!in_array(Route::currentRouteName(), array('getsubscriptionplans', 'subscribeplan', 'usersubscribe', 'usercardadd', 'addcard', 'getaboutalumni', 'getaboutalumni2', 'getbusinessopportunity', 'getbusinessopportunitysession', 'getalumniid', 'addupdatealumnipersonalinformation'))) {
                            return redirect()->route('getalumniid')->with('error', 'Please complete you profile');                        
                        }
                    }
                        if (!in_array(Route::currentRouteName(), array('getcheckout', 'applycoupon', 'paymentmethod', 'addpaymentcard', 'savepaymentcard', 'savepayment'))) {
                            Session::forget('coupon_id');
                            Session::forget('coupon_code');
                            Session::forget('coupon_price');
                        }
//                    if (in_array(Route::currentRouteName(), array('user_dashboard'))) {
//                        return redirect()->route('user_dashboard');                        
//                    }
                }
            } else {
                $team = AlumniUserTeam::join('sports', 'sports.id', 'alumni_user_teams.sports_id')->where('alumni_user_teams.user_id', $userId)->get();
                $fan_information = $team;
                if($fan_information->isEmpty()) {
                    if(!in_array(Route::currentRouteName(),array('addfanleague','savefanleague','addfanteam','savefanteam','choosefancolor','savefancolor','deletefanteam'))) {
                        return redirect()->route('addfanleague')->with('error', 'Please complete you profile');                        
                    }
                } else {
                    if(empty($color_selection_1) || empty($color_selection_2)) {
                        if(!in_array(Route::currentRouteName(),array('addfanleague','savefanleague','addfanteam','savefanteam','choosefancolor','savefancolor','deletefanteam'))) {
                            return redirect()->route('addfanleague')->with('error', 'Please complete you profile');                        
                        }
                    }
                }                
            }
            
        } else {
            return redirect()->route('login')->with('error', 'Please login now');
        }
        return $next($request);
    }
}
