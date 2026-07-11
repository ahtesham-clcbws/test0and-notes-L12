<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountBackupMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $backupData
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Account Data Backup Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account_backup',
        );
    }

    public function attachments(): array
    {
        $jsonData = json_encode($this->backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return [
            Attachment::fromData(fn () => $jsonData, 'data_backup.json')
                ->withMime('application/json'),
        ];
    }
}
