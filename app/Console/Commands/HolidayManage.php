<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Common;
use App\Models\Settings;
use App\Models\SavedPoster;
use App\Models\User;
use DB,DateTime;
use App\Models\Category;
use GuzzleHttp\Client;

class HolidayManage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:holidays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save holiday';

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
                
                $current_year = date('Y');

                $client = new Client();
                $response = $client->get('https://calendarific.com/api/v2/holidays', [
                    'query' => [
                        'api_key' => '6YihkOcVFE5W6qkRTPcXHuSlurtGR29P',
                        'country' => 'IN',
                        'year' => $current_year,
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                foreach ($data['response']['holidays'] as $holiday) {
                    $holidayDate = $holiday['date']['iso']; // YYYY-MM-DD

                    // Check if already exists for same year + date
                    $exists = Category::whereYear('date', $current_year)
                        ->exists();

                    if (!$exists) {
                        Category::create([
                            'name'        => $holiday['name'],
                            'date'        => $holidayDate,
                            'county_code' => "IN",
                            'image'       => asset('public/uploads/fest.svg'),
                        ]);
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