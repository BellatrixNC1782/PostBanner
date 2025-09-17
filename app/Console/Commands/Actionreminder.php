<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Common;
use App\Models\Settings;
use App\Models\User;
use App\Models\Clients;
use App\Models\Collection;
use App\Notifications\CollectionReminderMail;
use DB,DateTime;

class Actionreminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:actionreminder';

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
            $code='AAR';        

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