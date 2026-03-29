<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceGeneratedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $invoice,
        public string $pdfBinary,
        public string $filename,
        public string $body,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->invoice['email']['subject'] ?? ('Invoice ' . ($this->invoice['reference'] ?? '')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-generated',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn (): string => $this->pdfBinary, $this->filename)
                ->withMime('application/pdf'),
        ];
    }
}
