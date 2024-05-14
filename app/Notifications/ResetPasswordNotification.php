<?php

namespace App\Notifications;

use App\Mail\ForgotPasswordMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;


class ResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return mixed
     */

    public function toMail($notifiable): mixed
    {
        $resetUrl = $this->resetUrl($notifiable);

        return Mail::to($notifiable)->queue(new ForgotPasswordMail($notifiable, $resetUrl));
    }
}
