<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param string $otp  The plain-text 6-digit code (never stored plain)
     */
    public function __construct(public readonly string $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔑 كود استعادة كلمة المرور — عتاب',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
        );
    }
}
