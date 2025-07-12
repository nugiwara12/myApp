<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResidenceSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $residence)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Residence Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.residence_submitted', // ✅ Your actual Blade file
            with: [
                'residence' => $this->residence
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
