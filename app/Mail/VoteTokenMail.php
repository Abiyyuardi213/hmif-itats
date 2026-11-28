<?php

namespace App\Mail;

use App\Models\Election;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoteTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Election $election,
        public string $voterName,
        public string $ballotUrl,
        public string $expiresAtFormatted
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Token Surat Suara Rahasia — '.$this->election->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vote-token',
        );
    }
}
