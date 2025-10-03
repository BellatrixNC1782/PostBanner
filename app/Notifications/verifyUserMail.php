<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\Common;

class verifyUserMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage {
        
        $setting_email_val = 'support@postbanner.com';
        $setting_email_value = Common::getSetting('FEEDBACK_EMAIL');
        if (!empty($setting_email_value)) {
            $setting_email_val = $setting_email_value;
        }
        $setting_val = 5;
        $setting_value = Common::getSetting('alias_name', 'EMAIL_MOBILE_OTP_EXPIRE_TIME');

        if (!empty($setting_value)) {
            $setting_val = $setting_value;
        }
        
        $user_name = 'User';
        
        if(!empty($notifiable->user_name)){
            $user_name = $notifiable->user_name;
        }
        
        return (new MailMessage)
                        ->subject('Email Verification for My Daily Post')
                        ->greeting('Dear ' . $user_name . ',')
                        ->line('')
                        ->line(new HtmlString("Welcome to My Daily Post. To protect your privacy, please use the verification code below to activate your account:"))
                        ->line('')
                        ->line(new HtmlString('Verification Code: <b>' . $notifiable->email_otp . '</b>'))
                        ->line(new HtmlString('Note: <b>This code expires in '. $setting_val .' minutes</b>'))
                        ->line('')
                        ->line("If you received this email by mistake or did not authorize this request, please contact our support team at " . $setting_email_val . ".")
                        ->line('')
                        ->line('Thank you!')
                        ->salutation(new HtmlString("Best regards,<br>Team My Daily Post"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
