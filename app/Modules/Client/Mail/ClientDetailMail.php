<?php

namespace App\Modules\Client\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Log;

class ClientDetailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $plainPassword;
    public $login_url;

    /**
     * Create a new message instance.
     */
    public function __construct($client, $plainPassword, $login_url)
    {
        $this->client = $client;
        $this->plainPassword = $plainPassword;
        $this->login_url = $login_url;
    }
 
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            
            to: $this->client->email,
            from: env('MAIL_FROM_ADDRESS'),
            subject: 'Your Account Credentials'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Client::client.client-details-email',
            with: ['client' => $this->client, 'plain_pasword' => $this->plainPassword, 'login_url' => $this->login_url]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
