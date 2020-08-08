<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerApproved extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $promocode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $promocode)
    {
        $this->user = $user;
        $this->promocode = $promocode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.partners.approved')
                    ->text('emails.partners.approved_plain')
                    ->with([
                        'promocode' => $this->promocode
                    ]);
    }
}
