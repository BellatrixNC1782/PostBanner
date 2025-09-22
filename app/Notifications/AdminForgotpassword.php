<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Forgotpassword;
use Illuminate\Support\HtmlString;


class AdminForgotpassword extends Notification {

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
                        ->subject('Forgot password verification')
                        ->greeting('Dear ' . $notifiable->first_name . ' ' . $notifiable->last_name . ',')
                        ->line('')
                        ->line('It seems you have forgotten the password. Please find below the verification code to reset the new password to log in.')
                        ->line(new HtmlString('Verification code :  <b>' . $notifiable->msg_otp . '</b>'))
                        ->line('')
                        ->line('If you have not requested a password reset, please ignore this email.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
                //
        ];
    }

}
