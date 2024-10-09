<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TolakLimitSampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $userPenerima;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$userPenerima)
    {
        $this->data = $data;
        $this->userPenerima = $userPenerima;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Penolakan Limit Sample')
                    ->view('mail.tolakLimitSampleMail');
    }
}