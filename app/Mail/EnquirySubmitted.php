<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquirySubmitted extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact.enquiry')
                    ->text('emails.contact.enquiry_plain')
                    ->with([
                        'last_name' => $this->data['last_name'],
                        'email' => $this->data['email'],
                        'subject' => $this->data['subject'],
                        'body' => $this->data['message']
                    ]);
    }
}
