<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderLSWillExpired extends Mailable
{
    use Queueable, SerializesModels;
    public $areaParts;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($areaParts)
    {
        $this->areaParts = $areaParts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notification Will Expired Limit Sample')
                    ->view('mail.reminderLSWillExpired');
    }
}
