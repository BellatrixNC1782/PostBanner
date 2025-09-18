<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use DB;
use Auth;
use Storage;
use App\Models\Email;
use App\Models\Settings;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;
use Image;
use PDF;
use App\Models\UserNotification;
use App\Models\UserAlumniInformations;
use App\Models\Notifications;
use App\Models\Event;
use App\Models\AlumniUserTeam;
use Exception;
use Carbon\Carbon;
use Google\Client as GoogleClient;
use FFMpeg;
use Aws\CloudFront\CloudFrontClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Common extends Model
{
    
    public static function generateOtp()
    {
        $setting_val = 5;
        $setting_value = Settings::where('alias_name','EMAIL_MOBILE_OTP_EXPIRE_TIME')->get();
      
        if(!$setting_value->isEmpty())
        {
            $setting_val = $setting_value[0]->setting_value;
        }
        $otp_expire_time = date('Y-m-d H:i:s', strtotime('+'.$setting_val.' minute'));

        $otp_val = 'yes';
        $otp_value = Settings::where('alias_name', 'RANDOM_OTP')->get();

        if (!$otp_value->isEmpty()) {
            $otp_val = $otp_value[0]->setting_value;
        }
        if ($otp_val == 'yes') {
            $user_otp = mt_rand(1000, 9999);
        } else {
            $user_otp = "1234";
        }
        return array('expire_time'=>$otp_expire_time,'user_otp'=>$user_otp);
    }

    public static function generateTimeZone($lat,$long)
    {
        try {
            $timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location=".$lat.",".$long."&timestamp=".time()."&key=".env('GAPI_KEY');

            $ch = curl_init();

            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$timezoneAPI);
            // Execute
            $result=curl_exec($ch);
            // Closing
            curl_close($ch);

            $response = json_decode($result, true);

            if(!$response)
            {                
                return array('status' => 0, 'message' => "Timezone not found.");
            }

            return array('status' => 1, 'message' => 'success', 'data' => $response);
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    // upload image
    public static function uploadSingleImage($image, $path, $data = array())
    {
        try {
            $name = uniqid() . "_" . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/' . $path);
            if ($image->move($destinationPath, $name)) {
                return array('status' => 1, 'message' => 'success', 'data' => $name);
            } else {
                return array('status' => 0);                
            }
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    public static function getEmailTemplate($alias,$arrayreplace=array(),$arrayreplacedata=array())
    {
        $user_data = Email::where('alias',$alias)->select('subject','content')->first();
       
        $arrayreplacedata = str_replace('$', '\$', $arrayreplacedata);
       
        $content=preg_replace($arrayreplace, $arrayreplacedata, $user_data['content']);
        $subject=preg_replace($arrayreplace, $arrayreplacedata, $user_data['subject']);

        $data=array(
            'content'=>$content,
            'subject'=>$subject
        );

        return $data;
    }

    public static function getNotificationTemplate($alias,$arrayreplace=array(),$arrayreplacedata=array())
    {
        
        $user_data = Notifications::where('alias',$alias)->select('alias','content','diplink_id','title','logoimage','redirectid')->first();
       // dd($user_data);
        $content=preg_replace($arrayreplace, $arrayreplacedata, $user_data['content']);
        $diplink_id=preg_replace($arrayreplace, $arrayreplacedata, $user_data['diplink_id']);
        $alias=preg_replace($arrayreplace, $arrayreplacedata, $user_data['alias']);
        $title=preg_replace($arrayreplace, $arrayreplacedata, $user_data['title']);
        $logoimage=preg_replace($arrayreplace, $arrayreplacedata, $user_data['logoimage']);
        $redirectid=preg_replace($arrayreplace, $arrayreplacedata, $user_data['redirectid']);
        
        $data=array(
            'message'=>strip_tags($content),
            'redirect_key'=>$alias,
            'title'=>$title,
            'logoimage'=>$logoimage,
            'id'=>$redirectid,
        );
      
        return $data;
    }

    public static function saveNotification($data, $type = '')
    {
        $save_notification = new UserNotification();
        $save_notification->from_id = $data['from_id'];
        $save_notification->send_id = $data['to_id'];
        $save_notification->redirection_id = isset($data['redirection_id']) ? $data['redirection_id'] : '';
        $save_notification->message_test = strip_tags($data['notification_text']);
        $save_notification->redirect_key = isset($data['redirect_key']) ? $data['redirect_key'] : '';
        if(isset($data['display_type'])){
            $save_notification->display_type = $data['display_type'];
        }
        if(isset($data['display_flag'])){
            $save_notification->display_flag = $data['display_flag'];
        }           
        $save_notification->save();
    }

    public static function getMaxAttempt($alias)
    {
        $maximum_attempt = 5;
        $setting_value = Settings::where('alias_name',$alias)->get();
        if(!$setting_value->isEmpty())
        {
            $maximum_attempt = $setting_value[0]->setting_value;
        }

        return $maximum_attempt;
    }

   /* public static function getS3PublicUrl($object_path = '')
    {
        $s3Url = "https://".\Config::get('filesystems.disks.s3.bucket').'.s3.'.\Config::get('filesystems.disks.s3.region').'.amazonaws.com/';

        $s3UrlReplace=array("https://".\Config::get('filesystems.disks.s3.bucket').'.s3.'.\Config::get('filesystems.disks.s3.region').'.amazonaws.com/',
                            "https://".\Config::get('filesystems.disks.s3.bucket').'.s3.'.'amazonaws.com/',
                            "https://".'s3-'.\Config::get('filesystems.disks.s3.region').'.amazonaws.com/'.\Config::get('filesystems.disks.s3.bucket').'/',
                            "https://".'s3.'.\Config::get('filesystems.disks.s3.region').'.amazonaws.com/'.\Config::get('filesystems.disks.s3.bucket').'/');

        $object_path=str_replace($s3UrlReplace,array(''), $object_path);

        if(!empty($object_path))
        {
            //$returndata=(string) Storage::disk('s3')->temporaryUrl($object_path, now()->addMinutes(365));
            $returndata=(string) $s3Url.$object_path;
        }
        else
        {
            $returndata=$object_path;
        }

        return $returndata;

       //return $object_path;
    }*/

    public static function getS3PublicUrl($object_path = '')
    {    
       // $s3Url = "https://".\Config::get('filesystems.disks.s3.bucket').'.s3.'.\Config::get('filesystems.disks.s3.region').'.amazonaws.com/';

        $object_path=config('filesystems.disks.s3.url').$object_path;



        try {

            $signedUrl = Common::createSignedUrl(
                $object_path,
                storage_path('app/keys/private_key.pem'), // Path to the private key
                env('YOUR_KEY_PAIR_ID'), // Replace with your CloudFront Key Pair ID
                36000 //URL valid for 1 minute   (3600) 1 hour
            );

            return $signedUrl;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }   

    public static function createSignedUrl($resourceUrl, $privateKeyPath, $keyPairId, $expireSeconds)
    {
        $keyPairId = $keyPairId; // Replace with your Key Pair ID
        $privateKeyPath = $privateKeyPath; // Replace with the path to your private key
        $resourceUrl = $resourceUrl; // Replace with your CloudFront resource URL
        $expires = time() + $expireSeconds;

       // try {

            $cloudFront = new CloudFrontClient([
                'version' => 'latest',
                'region'  => 'us-east-1'
            ]);

            // Generate the signed URL
            $signedUrl = $cloudFront->getSignedUrl([
                'url'         => $resourceUrl,
                'expires'     => $expires,
                'key_pair_id' => $keyPairId,
                'private_key' => $privateKeyPath, // Corrected parameter key and value
            ]);

            return $signedUrl;
       // } catch (Exception $e) {

         //   echo "Error: " . $e->getMessage();

       // }
    }

    public static function UsaTimezone($time,$data = array()){
        $current_date = [];
        $timezone = [];

        $minutes_to_add = 10;

        $c_date = date("Y-m-d H:i:s");
        // Denver timezone convert
        $tz_user_d = new DateTime("$c_date +00");
        $t_zone_d = new DateTimeZone('America/Denver');
        $tz_user_d->setTimezone($t_zone_d);
        $timezone_date=$tz_user_d->format('Y-m-d H:i:s');
        $expected_date=$tz_user_d->format("Y-m-d ".$time);

        $newtimestamp = strtotime($expected_date.' + '.$minutes_to_add.' minute');
        $stamp=date('Y-m-d H:i:s', $newtimestamp);

        if(strtotime($expected_date)<=strtotime($timezone_date) && strtotime($stamp)>=strtotime($timezone_date))
        {
            array_push($current_date,$timezone_date);
            array_push($timezone,'America/Denver');
        }

        // Anchorage time zone convert
        $tz_user_a = new DateTime("$c_date +00");
        $t_zone_a = new DateTimeZone('America/Anchorage');
        $tz_user_a->setTimezone($t_zone_a);
        $timezone_date=$tz_user_a->format('Y-m-d H:i:s');
        $expected_date=$tz_user_a->format("Y-m-d ".$time);

        $newtimestamp = strtotime($expected_date.' + '.$minutes_to_add.' minute');
        $stamp=date('Y-m-d H:i:s', $newtimestamp);

        if(strtotime($expected_date)<=strtotime($timezone_date) && strtotime($stamp)>=strtotime($timezone_date))
        {
            array_push($current_date,$timezone_date);
            array_push($timezone,'America/Anchorage');
        }

        // phoenix time zone convert
        $tz_user_p = new DateTime("$c_date +00");
        $t_zone_p = new DateTimeZone('America/Phoenix');
        $tz_user_p->setTimezone($t_zone_p);
        $timezone_date=$tz_user_p->format('Y-m-d H:i:s');
        $expected_date=$tz_user_p->format("Y-m-d ".$time);

        $newtimestamp = strtotime($expected_date.' + '.$minutes_to_add.' minute');
        $stamp=date('Y-m-d H:i:s', $newtimestamp);

        if(strtotime($expected_date)<=strtotime($timezone_date) && strtotime($stamp)>=strtotime($timezone_date))
        {
            array_push($current_date,$timezone_date);
            array_push($timezone,'America/Phoenix');
        }

        // Chicago time zone convert
        $tz_user_c = new DateTime("$c_date +00");
        $t_zone_c = new DateTimeZone('America/Chicago');
        $tz_user_c->setTimezone($t_zone_c);
        $timezone_date=$tz_user_c->format('Y-m-d H:i:s');
        $expected_date=$tz_user_c->format("Y-m-d ".$time);

        $newtimestamp = strtotime($expected_date.' + '.$minutes_to_add.' minute');
        $stamp=date('Y-m-d H:i:s', $newtimestamp);

        if(strtotime($expected_date)<=strtotime($timezone_date) && strtotime($stamp)>=strtotime($timezone_date))
        {
            array_push($current_date,$timezone_date);
            array_push($timezone,'America/Chicago');
        }

        // Los_Angeles time zone convert
        $tz_user_l = new DateTime("$c_date +00");
        $t_zone_l = new DateTimeZone('America/Los_Angeles');
        $tz_user_l->setTimezone($t_zone_l);
        $timezone_date=$tz_user_l->format('Y-m-d H:i:s');
        $expected_date=$tz_user_l->format("Y-m-d ".$time);

        $newtimestamp = strtotime($expected_date.' + '.$minutes_to_add.' minute');
        $stamp=date('Y-m-d H:i:s', $newtimestamp);

        if(strtotime($expected_date)<=strtotime($timezone_date) && strtotime($stamp)>=strtotime($timezone_date))
        {
            array_push($current_date,$timezone_date);
            array_push($timezone,'America/Los_Angeles');
        }

        // Honolulu time zone convert
        $tz_user_h = new DateTime("$c_date +00");
        $t_zone_h = new DateTimeZone('Pacific/Honolulu');
        $tz_user_h->setTimezone($t_zone_h);
        $timezone_date=$tz_user_h->format('Y-m-d H:i:s');
        $expected_date=$tz_user_h->format("Y-m-d ".$time);

        $newtimestamp = strtotime($expected_date.' + '.$minutes_to_add.' minute');
        $stamp=date('Y-m-d H:i:s', $newtimestamp);

        if(strtotime($expected_date)<=strtotime($timezone_date) && strtotime($stamp)>=strtotime($timezone_date))
        {
            array_push($current_date,$timezone_date);
            array_push($timezone,'Pacific/Honolulu');
        }

        $comparedate='';
        $utcdate='';
        if(!empty($current_date))
        {
            $comparedate= explode(' ', $current_date[0]);
            if(!empty($comparedate))
            {
                $comparedate=$comparedate[0];
            }

            $utcdate= explode(' ', $expected_date);
            if(!empty($utcdate))
            {
                $utcdate=$utcdate[0];
            }

        }

        $finaldata=array('date'=>$current_date,'timezone'=>$timezone,'comparewith'=>$comparedate,'utcdate'=>$utcdate);
        return $finaldata;
    }

    public static function videoUploadBlock($request) {
        try {
            $day = date('Yd');
            $videoName = $day . '/' . time() . '.' . $request->video_file->getClientOriginalExtension();
            $video = $request->file('video_file');

            $t = Storage::disk('s3')->put($videoName, file_get_contents($video), 'public/' . $day);
            $video_url = Storage::disk('s3')->url($videoName);
            $res = array('video_url' => $video_url,'presign_video_url'=>Common::getS3PublicUrl($video_url));
            return array('status' => 1, 'message' => 'success', 'data' => $res);
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    public static function uploadVideoS3($video) {
        try {
            $folder = "PostBanner";
            $videoName = uniqid() . "_" . time() . '.' . $video->getClientOriginalExtension();
            $path = $folder . '/' . $videoName;
            $t = Storage::disk('s3')->put($path, file_get_contents($video), 'public/');
            $video_url = Storage::disk('s3')->url($path);
//            pr($video_url);die;
            $res = array('video_url' => $video_url,'video_name'=>$videoName);
            return array('status' => 1, 'message' => 'success', 'data' => $res);
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }
    public static function uploadVideoS3Web($video) {
        try {
            $folder = "PostBanner";
            $videoName = uniqid() . "_" . time() . '.' . $video->getClientOriginalExtension();

            $path = $folder . '/' . $videoName;
            $originalVideoPath = $video->getRealPath();

            // Define the watermark image path
            $watermarkPath = public_path('images/watermark_logo.png');

            // Ensure the temp directory exists
            $tempDirectory = storage_path('app/temp/');
            if (!file_exists($tempDirectory)) {
                mkdir($tempDirectory, 0777, true); // Create directory if not exists
            }

            // Create a temporary path for the watermarked video
            $watermarkedVideoPath = $tempDirectory . uniqid() . '_watermarked.mp4';

            // Define the watermark size (e.g., 100px width)
            $watermarkWidth = 100; // Set the smaller width for the watermark
            // Generate watermarked video using FFmpeg
            $command = "ffmpeg -i $originalVideoPath -i $watermarkPath -filter_complex \"[1:v]scale=$watermarkWidth:-1[wm]; [0:v][wm]overlay=W-w-10:H-h-10\" -c:a aac -c:v libx264 -strict experimental $watermarkedVideoPath 2>&1";
            exec($command, $output, $returnVar);

            // Check if FFmpeg execution was successful
            if ($returnVar !== 0) {
                \Log::error("FFmpeg execution failed: " . implode("\n", $output));
                return ['status' => 0, 'message' => 'FFmpeg execution failed.'];
            }

            // Check if watermarked video was generated
            if (!file_exists($watermarkedVideoPath)) {
                \Log::error("Watermarked video not found: " . $watermarkedVideoPath);
                return ['status' => 0, 'message' => 'Watermarked video was not generated.'];
            }

            // Upload the video to S3
            $watermarkedVideoResource = file_get_contents($watermarkedVideoPath); // Get file content

            $path = $folder . '/' . $videoName;

            // Upload to S3 disk
            $s3Path = Storage::disk('s3')->put($path, $watermarkedVideoResource, 'public/');

            // Check if the upload was successful
            if (!$s3Path) {
                \Log::error('Failed to upload to S3');
                return ['status' => 0, 'message' => 'Failed to upload video to S3.'];
            }

            // Get the URL of the uploaded video from S3
            $video_url = Storage::disk('s3')->url($path);

            // Clean up the local watermarked video after uploading
            unlink($watermarkedVideoPath);

            // Return success response
            return ['status' => 1, 'message' => 'success', 'data' => ['video_url' => $video_url, 'video_name' => $videoName]];
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }

    public static function getS3PublicUrlUser($object_path = '')
    {     
       // $s3Url = "https://".\Config::get('filesystems.disks.s3.bucket').'.s3.'.\Config::get('filesystems.disks.s3.region').'.amazonaws.com/';
        $object_path=config('filesystems.disks.s3.url').$object_path;

        try {
            $signedUrl = Common::createSignedUrl(
                $object_path,
                storage_path('app/keys/private_key.pem'), // Path to the private key
                env('YOUR_KEY_PAIR_ID'), // Replace with your CloudFront Key Pair ID
                360000 //URL valid for 60*5 5min (3600) 1 hour
            );

            return $signedUrl;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

//public static function uploadVideoS3Web($video) {
//        try {
//            $videoName = uniqid() . "_" . time() . '.' . $video->getClientOriginalExtension();
//            dd($videoName, file_get_contents($video));
//            $t = Storage::disk('s3')->put($videoName, file_get_contents($video), 'public/');
//            $video_url = Storage::disk('s3')->url($videoName);
////            pr($video_url);die;
//            $res = array('video_url' => $video_url,'video_name'=>$videoName);
//            return array('status' => 1, 'message' => 'success', 'data' => $res);
//        } catch (\Exception $e) {
//            return array('status' => 0, 'message' => $e->getMessage());
//        }
//}

    public static function uploadImageS3($image,$flag='') {
        $img_name = uniqid() . "_" . time() . '.' . $image->getClientOriginalExtension();
        try {
            $folder = "PostBanner";
            $day = date('Yd');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image = $image;

            $img = Image::make($image);

            if($flag == 'logo'){
                $img->resize(180, 80, function ($constraint) {
//                    $constraint->aspectRatio();
                });
            }else if($flag == 'standard'){
                $img->resize(200, 200, function ($constraint) {
//                    $constraint->aspectRatio();
                });
            }else if($flag == 'blog'){
                $img->resize(1178, 651, function ($constraint) {
//                    $constraint->aspectRatio();
                });
            }else{
//                $img->resize(null, 1000, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
            }

            //detach method is the key! Hours to find it... :/
            $resource = $img->stream()->detach();

            $path = $folder . '/' . $imageName;

            $t = Storage::disk('s3')->put($path, $resource, 'public/');
            $image_url = Storage::disk('s3')->url($path);
            $res = array('image_url' => $image_url,'image_name' => $imageName);

            return array(
                'status' => 1,
                'message' => 'success',
                'data' => $res
            );
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    public static function uploadImageS3_base64($image,$flag = '') {
        list($baseType, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        try {
            $folder = "PostBanner";
            $day = date('Yd');
            $imageName = $day . '/' .uniqid().time() . '.png';

            $img = Image::make($image);

            if($flag == 'logo'){
                $img->resize(180, 80, function ($constraint) {
                    //$constraint->aspectRatio();
                });
            }else if($flag == 'banner'){
                $img->resize(1920, 540, function ($constraint) {
                    //$constraint->aspectRatio();
                });
            }else if($flag == 'product'){
                $img->resize(800, 800, function ($constraint) {
                    //$constraint->aspectRatio();
                });
            }else if($flag == 'gallery'){
                $img->resize(400, 400, function ($constraint) {
                    //$constraint->aspectRatio();
                });
            }else if($flag == 'standard'){
                $img->resize(200, 200, function ($constraint) {
//                    $constraint->aspectRatio();
                });
            }else{
                $img->resize(null, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            //detach method is the key! Hours to find it... :/
            $resource = $img->stream()->detach();

            $path = $folder . '/' . $imageName;

            $p = Storage::disk('s3')->put($path, $resource, 'public' . $day);

            $image_url = Storage::disk('s3')->url($path);
            $res = array('image_url' => $image_url,'image_name' => $imageName,'presign_image_url'=>Common::getS3PublicUrl($image_url));
            return array(
                'status' => 1,
                'message' => 'success',
                'data' => $res
            );
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    public static function uploadPdfS3($image,$flag='') {
        //$img_name = uniqid() . "_" . time() . '.' . $image->getClientOriginalExtension();
        try {
            //echo '<pre>'; print_r($image); echo '</pre>'; die;
            $day = date('Yd');
            $folder = "PostBanner";
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $path = $folder . '/' . $imageName;
            $t = Storage::disk('s3')->put($path,file_get_contents($image),'public/');
            $image_url = Storage::disk('s3')->url($path);
            $res = array('image_url' => $image_url,'image_name' => $imageName);
            return array(
                'status' => 1,
                'message' => 'success',
                'data' => $res
            );
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }
    
    public static function uploadPdfS3Excel($image,$key,$flag='') {
        //$img_name = uniqid() . "_" . time() . '.' . $image->getClientOriginalExtension();
        try {
            //echo '<pre>'; print_r($image); echo '</pre>'; die;
            $day = date('Yd');
            $folder = "PostBanner";
            $imageName = time() . $key . '.' . $image->getClientOriginalExtension();
            $path = $folder . '/' . $imageName;
            $t = Storage::disk('s3')->put($path,file_get_contents($image),'public/');
            $image_url = Storage::disk('s3')->url($path);
            $res = array('image_url' => $image_url,'image_name' => $imageName);
            return array(
                'status' => 1,
                'message' => 'success',
                'data' => $res
            );
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    public static function uploadImageVideoS3_base64($image, $flag = '') {
        $extension = explode('/', mime_content_type($image))[1];

        list($baseType, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $folder = "PostBanner";
        
        try{
            $day = date('Yd');
            $imageName = uniqid() . '.' . $extension;
            $path = $folder . '/' . $imageName;
            $p = Storage::disk('s3')->put($path, $image, 'public' . $day);

            $res = array('image_url' => $imageName, 'extension' => $extension);

            return array(
                'status' => 1,
                'message' => 'success',
                'data' => $res
            );
        } catch (\Exception $e) {
            return array('status' => 0, 'message' => $e->getMessage());
        }
    }

    public static function checkImageExtension($image) {
        $extensionlist = array('jpg', 'jpeg', 'png', 'JPG', 'svg', 'SVG', 'JPEG', 'PNG','gif','BMP','bmp','x-ms-bmp', 'WEBP', 'webp');
        $check = $image->getClientOriginalExtension();
        $result = in_array($check, $extensionlist);
        if ($result) {
            return 200;
        } else {
            return 401;
        }
    }
    public static function checkPdfExtension($pdf) {
        $extensionlist = array('pdf','PDF');
        $check = $pdf->getClientOriginalExtension();
        $result = in_array($check, $extensionlist);
        if ($result) {
            return 200;
        } else {
            return 401;
        }
    }
    public static function getSetting($alias_name) {
        global $setting;
        $setting = Settings::where('alias_name', $alias_name)->get();
        if ($setting->isEmpty()) {
            return null;
        }
        return $setting->first()->setting_value;
    }

    public static function sendPushNotification($token, $data, $devicetype, $flag = 0) {
        $fcm = $token; // Assume $token contains the FCM token for the user.

        if (!$fcm) {
            return response()->json(['message' => 'User does not have a device token'], 400);
        }

        $title = "test Notification";
        $description = "testing ongoing ask test";
        $projectId = "bannerapp-9867e";

        // Path to your Google service account credentials JSON file.
        $credentialsFilePath = \Storage::path('file.json');

        // Create a new Google Client instance.
        
        $client = new GoogleClient();

        $client->setAuthConfig($credentialsFilePath); // Set the credentials file path.
        
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion(); // Refresh the token using the service account credentials.
        $token = $client->getAccessToken(); // Retrieve the OAuth 2.0 access token.
        

        if (empty($token) || !isset($token['access_token'])) {
            return response()->json(['message' => 'Failed to retrieve access token'], 500);
        }

        // Use the access token in the Authorization header.

        $access_token = $token['access_token'];
        $headers = [
            "Authorization: Bearer " . $access_token,
            'Content-Type: application/json'
        ];

        if (isset($data['jobId'])) {
            $datas['jobId'] = (string) $data['jobId'];
        }

        $datas['redirect_key'] = 'notification_list';
        if(isset($data['redirect_key']))
        {
            $datas['redirect_key'] = $data['redirect_key'];
        }

        $datas['text'] = $data['message'];
//        $datas['title'] = $data['title'];
        $datas['sound'] = 'default';
        $datas['message'] = $data['message'];
//        $datas['logoimage'] = $data['logoimage'];
        if ($devicetype == "IOS") {
            $datas['title'] = 'PostBanner';
        } else {
            $datas['title'] = 'PostBanner';
        }
        $datas['body'] = $data['message'];

        $arrayToSend = array('body' => $datas);

        //\Log::channel('cronlog')->info('Notification Data: ' . $datas);
        // Prepare the notification data.
        $data_payload = [
            "message" => [
                "token" => $fcm[0],
                "notification" => [
                    "title" => 'PostBanner',
                    "body" => $data['message'],
                ],
                'data' => $datas,
            ]
        ];

        $payload = json_encode($data_payload);

        // Initialize curl to send the FCM notification.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging.
        // Execute curl and get the result.
        $result = curl_exec($ch);

        // Log the result for debugging purposes.
        /*if (curl_errno($ch)) {
            \Log::channel('cronlog')->error('cURL Error: ' . curl_error($datas));
        } else {
            \Log::channel('cronlog')->info('Notification sent: ' . json_encode($datas));
        }*/

        // Close the curl connection.
        curl_close($ch);

        if ($flag == 1) {
            echo $result;
            exit;
        }

        return true;
    }

    public static function sendOtp($recipients, $message)
    {
        $account_sid = Settings::where('alias_name','TWILIO_ACCOUNT_SID')->get();
        $auth_token = Settings::where('alias_name','TWILIO_AUTH_TOKEN')->get();
        $twilio_number = Settings::where('alias_name','TWILIO_PHONE_NUMBER')->get();

        $client = new Client($account_sid[0]->setting_value, $auth_token[0]->setting_value);
        try
        {
            $res = $client->messages->create($recipients, ['from' => $twilio_number[0]->setting_value, 'body' => $message]);
            return array('status' => true, 'message' => $res);
        }
        catch (\Exception $e)
        {
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    public static function distance($lat1, $lon1, $lat2, $lon2) {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;

      //echo ($miles * 1.609344).' km'; echo "<pre>";
      //echo ($miles).' mile'; die;
      //print_r($miles); die;

      $miles = number_format((float)$miles, 2, '.', '');
      return (double) $miles;
    }

    public static function delete_s3_file($file){
        Storage::disk('s3')->delete($file);
        return true;
    }    

    public static function timezoneInteractionConvertDate($str, $userTimezone, $format = 'Y-m-d H:i:s'){
        $new_str = new DateTime($str, new DateTimeZone( $userTimezone ) );
        $new_str->setTimeZone(new DateTimeZone('UTC'));
        return $new_str->format($format);
    }

    public static function timezoneEventDetailConvertDate($str,$timezone, $format = 'Y-m-d H:i:s'){         
        $new_str = new DateTime($str);

        $new_str->setTimeZone(new DateTimeZone( $timezone ));
        return $new_str->format($format);
    }
    public static function convertFromUTC($dateTime, $toTimezone, $format = 'Y-m-d H:i:s') {
        $newDateTime = new DateTime($dateTime, new DateTimeZone('UTC'));
        $newDateTime->setTimezone(new DateTimeZone($toTimezone));
        return $newDateTime->format($format);
    }

    public static function timezoneScheduleSlotConvertDate($str,$timezone, $format = 'Y-m-d H:i:s'){                
        // Create a Carbon instance for your UTC time
        $utcTime = Carbon::parse($str, 'UTC');

        // Define the 'America/Los_Angeles' time zone
        $timezone = new DateTimeZone($timezone);

        // Set the time zone for the UTC time
        $utcTime->setTimezone($timezone);

/*        // Get the time zone offset including DST savings
        $offset = $timezone->getOffset(new DateTime());

        // Calculate the offset in hours and minutes
        $offsetHrs = $offset / 3600;
        $offsetMins = ($offset % 3600) / 60;

        // Subtract the offset to get the time in DST
        $localTimeInDST = $utcTime->copy()->subHours($offsetHrs)->subMinutes($offsetMins); */

        // Format the result
        $dateToReturn = $utcTime->format('Y-m-d H:i:s');
        
        return $dateToReturn;
    }
    
    public static function timezoneConvertDate($str,$timezone = 'UTC', $format = 'Y-m-d H:i:s'){
         

        $new_str = new DateTime($str);

        $new_str->setTimeZone(new DateTimeZone( $timezone ));
        return $new_str->format($format);
    }
    public static function adminconvertTimezone($str, $format) {

        $check_timezone_exist = Settings::where('alias_name', 'ADMIN_TIME_ZONE')->get()->first();
        if (!empty(Auth::guard('admin')->User()->time_zone)) {
            $user_timezone = Auth::guard('admin')->User()->time_zone;
        } else {
            $user_timezone = '';
        }

        if (!empty($format)) {
            $format = $format;
        } else {
            $format = 'm-d-Y h:i A';
        }

        if ($user_timezone) {
            $tz = $user_timezone; // or whatever zone you're after
        } else {
            $tz = date_default_timezone_get(); // or whatever zone you're after    
        }
        $new_str = new DateTime($str);
        $new_str->setTimeZone(new DateTimeZone($tz));
        return $new_str->format($format);
    }
    
    public static function adminconvertViewTimezone($str) {

        $check_timezone_exist = Settings::where('alias_name', 'ADMIN_TIME_ZONE')->get()->first();
        if (!empty($check_timezone_exist)) {
            $user_timezone = Common::getSetting('ADMIN_TIME_ZONE');
        } else {
            $user_timezone = '';
        }

        if ($user_timezone) {
            $tz = $user_timezone; // or whatever zone you're after
        } else {
            $tz = date_default_timezone_get(); // or whatever zone you're after    
        }
        $new_str = new DateTime($str);
        $new_str->setTimeZone(new DateTimeZone($tz));
        return $new_str;
    }
    
    public static function adminconvertEventTimezone($id, $str) {

        $check_timezone_exist = Event::where('id', $id)->get()->first();
        if (!empty($check_timezone_exist)) {
            $user_timezone = $check_timezone_exist->timezone_id;
        } else {
            $user_timezone = '';
        }

        if ($user_timezone) {
            $tz = $user_timezone; // or whatever zone you're after
        } else {
            $tz = date_default_timezone_get(); // or whatever zone you're after    
        }
        $new_str = new DateTime($str);
        $new_str->setTimeZone(new DateTimeZone($tz));
        return $new_str;
    }
    public static function userConvertTimezone($date, $format, $timezone) {
        $dateObj = new \DateTime($date);
        $dateObj->setTimezone(new \DateTimeZone($timezone));
        return $dateObj->format($format);
    }

//    public static function userConvertTimezone($str, $format){
////        dd($str);
//        $tz = 'America/Los_Angeles';  
//        $new_str = new DateTime($str);
//
//        $new_str->setTimeZone(new DateTimeZone( $tz ));
////        echo $new_str;
//        return $new_str->format($format);
//    }
}