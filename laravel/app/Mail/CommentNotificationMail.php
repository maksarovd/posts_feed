<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\{Envelope, Content, Address, Attachment, Headers};


class CommentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('bondspear2020@gmail.com','Maksarov Dmitriy'),
            subject: 'Test send email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.example',
            with: [
                'title' => __('hello')
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/public/uploads/1718000554.jpeg'))
                ->as('image.jpeg')
        ];
    }

    public function headers(): Headers
    {
        return new Headers(
//            messageId: 'custom-message-id@example.com',
//            references: [
//                'previous-message@example.com'
//            ],
//            text: [
//                'X-Custom-Header' => 'Custom Value',
//            ],
        );
    }
}
