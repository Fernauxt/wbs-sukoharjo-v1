<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $statusName;
    public $notes;

    public function __construct($report, $statusName, $notes = null)
    {
        $this->report = $report;
        $this->statusName = $statusName;
        $this->notes = $notes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Laporan Anda Telah Diperbarui',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.status_update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
