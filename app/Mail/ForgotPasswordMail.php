<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('app.name')),
            to: $this->user->email,
            cc: $this->user->email,
            bcc: $this->user->email,
            replyTo: config('mail.from.address'),
            subject: trans('mail.forgot_password.subject'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */

    public function content(): Content
    {
        return new Content(
            view: 'emails.ForgotPasswordMail',
        );
    }
}
