<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Common;
use App\Models\Settings;
use App\Models\SavedPoster;
use App\Models\User;
use DB,DateTime;

class Sharereminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sharereminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Share reminder';

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
            $code='ASR';        

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
                
                $yesterday_date = date('Y-m-d',strtotime('-1 days'));
                
                $saved_post_list = SavedPoster::select('id','user_id')
                    ->where('is_notify', 'No')
                    ->whereDate('created_at', $yesterday_date)
                    ->get();
              
                if(!$saved_post_list->isEmpty()){
                    foreach($saved_post_list as $key => $val){
                        $userInfo = User::find($val->user_id);
                        
                        if(!empty($userInfo)){
                           
                            $notificationContent = [];
                            $notificationContent['message'] = "You started a poster yesterday – want to finish it now?";
                            $notificationContent['redirection_id'] = Null;
                            $notification_token = array($userInfo->device_token);

                            $type = 2;

                            if ($userInfo->push_notify == 'Yes' && $userInfo->device_token != Null) {
                                $sendNotification = Common::sendPushNotification($notification_token, $notificationContent, $userInfo->device_type, $type);
                            }

                            $save_notification = array(
                                'from_id' => $userInfo->id,
                                'to_id' => $userInfo->id,
                                'redirection_id' => Null,
                                'notification_text' => $notificationContent['message']
                            );
                            
                            $notificationdata = Common::saveNotification($save_notification);
                            
                            SavedPoster::where('id',$val->id)->update(array('is_notify' => 'Yes'));

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