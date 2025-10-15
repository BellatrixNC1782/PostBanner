<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Common;
use App\Models\Settings;
use App\Models\User;
use DB,DateTime;

class Useractionreminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:useractionreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Action reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $code='UAAR';        

            $user_detail = DB::table('tmp_cron_schedulars')
                            ->select('id','cron_name')
                            ->where('cron_name','=',$code)
                            ->get()->toArray();

            if(empty($user_detail))
            {
                DB::table('tmp_cron_schedulars')->insert([
                    'cron_name' => $code,
                    'is_process' => 1
                ]);
                
                $past_7_day_date = date('Y-m-d',strtotime('-7 days'));
                $past_15_day_date = date('Y-m-d',strtotime('-15 days'));
                $past_30_day_date = date('Y-m-d',strtotime('-30 days'));
                
                
                $usersWithoutPosters = User::select('users.*')
                        ->leftJoin('saved_posters', function ($join) {
                            $join->on('users.id', '=', 'saved_posters.user_id')
                                 ->whereNull('saved_posters.deleted_at');
                        })
                        ->whereNull('saved_posters.user_id')
                        ->where(function ($query){
                            $query->where('users.7_day_notify', 'No')
                                    ->orWhere('users.15_day_notify', 'No')
                                    ->orWhere('users.30_day_notify', 'No');
                        })
                        ->where(function ($query) use($past_7_day_date,$past_15_day_date,$past_30_day_date) {
                            $query->whereDate('users.created_at', $past_7_day_date)
                                    ->orWhereDate('users.created_at', $past_15_day_date)
                                    ->orWhereDate('users.created_at', $past_30_day_date);
                        })
                        ->get();
                
//                dd($past_30_day_date);

                if(!$usersWithoutPosters->isEmpty()){
                    foreach($usersWithoutPosters as $key => $val){
                        $check_date = date('Y-m-d',strtotime($val->created_at));
                        
                        $sevendayval = $val->{'7_day_notify'};
                        $fitendayval = $val->{'15_day_notify'};
                        $thirtydayval = $val->{'30_day_notify'};
                        
                        $type = 2;

                        if(($check_date == $past_7_day_date) && ($sevendayval == 'No')){
                            $notificationContent = [];
                            $notificationContent['message'] = "Need help getting started? Try our beginner templates.";
                            $notificationContent['redirection_id'] = Null;
                            $notification_token = array($val->device_token);
                            
                            if ($val->push_notify == 'Yes' && $val->device_token != Null) {
                                $sendNotification = Common::sendPushNotification($notification_token, $notificationContent, $val->device_type, $type);
                            }

                            $save_notification = array(
                                'from_id' => $val->id,
                                'to_id' => $val->id,
                                'redirection_id' => Null,
                                'notification_text' => $notificationContent['message']
                            );
                            
                            $notificationdata = Common::saveNotification($save_notification);
                            
                            User::where('id',$val->id)->update(array('7_day_notify' => 'Yes'));
                        }
                        if(($check_date == $past_15_day_date) && ($fitendayval == 'No')){
                            $notificationContent = [];
                            $notificationContent['message'] = "Don’t forget: You can resize posters for Instagram, Facebook & more.";
                            $notificationContent['redirection_id'] = Null;
                            $notification_token = array($val->device_token);
                            
                            if ($val->push_notify == 'Yes' && $val->device_token != Null) {
                                $sendNotification = Common::sendPushNotification($notification_token, $notificationContent, $val->device_type, $type);
                            }

                            $save_notification = array(
                                'from_id' => $val->id,
                                'to_id' => $val->id,
                                'redirection_id' => Null,
                                'notification_text' => $notificationContent['message']
                            );
                            
                            $notificationdata = Common::saveNotification($save_notification);
                            
                            User::where('id',$val->id)->update(array('15_day_notify' => 'Yes'));
                        }
                        if(($check_date == $past_30_day_date) && ($thirtydayval == 'No')){
                            $notificationContent = [];
                            $notificationContent['message'] = "Still exploring? Create your first poster in under 2 minutes!";
                            $notificationContent['redirection_id'] = Null;
                            $notification_token = array($val->device_token);
                            
                            if ($val->push_notify == 'Yes' && $val->device_token != Null) {
                                $sendNotification = Common::sendPushNotification($notification_token, $notificationContent, $val->device_type, $type);
                            }

                            $save_notification = array(
                                'from_id' => $val->id,
                                'to_id' => $val->id,
                                'redirection_id' => Null,
                                'notification_text' => $notificationContent['message']
                            );
                            
                            $notificationdata = Common::saveNotification($save_notification);
                            
                            User::where('id',$val->id)->update(array('30_day_notify' => 'Yes'));
                        }
                    }
                }
                

                DB::table('tmp_cron_schedulars')->where('cron_name','=',$code)->delete();
                echo "success";

            }else
            {
                DB::table('tmp_cron_schedulars')->where('cron_name','=',$code)->delete();
                echo "No Data found";exit;
            }

        }catch (\Exception $e){
            DB::table('tmp_cron_schedulars')->where('cron_name','=',$code)->delete();
            return $e->getMessage();
        } 
    }
}