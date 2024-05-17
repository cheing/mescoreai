<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReceipt extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $filePath;
    public $me88Username;
    public $username;
    public $userEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filePath, $me88Username, $username, $userEmail)
    {
        $this->filePath = $filePath;
        $this->me88Username = $me88Username;
        $this->username = $username;
        $this->userEmail = $userEmail;
    }

    public function build()
    {
        return $this->from('noreply@mescoreai.com')
                    ->subject('Deposit Receipt')
                    ->view('emails.receipt')
                    ->attach(storage_path('app/public/'.$this->filePath));
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Send Receipt',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.receipt',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
