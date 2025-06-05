<?php

namespace App\Mail;

use App\Models\CommissionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommissionRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commission;

    /**
     * Create a new message instance.
     */
    public function __construct(CommissionRequest $commission)
    {
        $this->commission = $commission;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Custom Commission Request'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.commission',
            with: [
                'commission' => $this->commission,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
