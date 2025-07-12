<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResidenceApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $residence;

    public function __construct($residence)
    {
        $this->residence = $residence;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Residence Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.residence_approved', // ✅ Blade view for approval
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
